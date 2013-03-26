<?php
namespace MailRoute\API\Tests;

use Jamm\Tester\ClassTest;
use MailRoute\API\Entity\ContactReseller;
use MailRoute\API\Entity\Reseller;
use MailRoute\API\IActiveEntity;
use MailRoute\API\IClient;
use MailRoute\API\MailRouteException;

class TestClient extends ClassTest
{
	/** @var ClientMock */
	private $Client;

	public function __construct(IClient $Client)
	{
		$this->Client = $Client;
	}

	public function testGetRootSchema()
	{
		$result = $this->Client->GET();
		$this->assertIsArray($result);
		$this->assertTrue(isset($result['reseller']));
	}

	public function testSchema()
	{
		$result = $this->Client->GET('reseller/schema');
		$this->assertIsArray($result);
		$this->assertTrue(isset($result['allowed_detail_http_methods']));
	}

	public function testResellerList()
	{
		$reseller_name = 'test '.microtime(1);
		/** @var IActiveEntity[] $resellers */
		$resellers   = array();
		$NewReseller = new Reseller($this->Client);
		$NewReseller->setName($reseller_name.'1');
		$resellers[] = $this->Client->API()->Reseller()->create($NewReseller);
		$resellers[] = $this->Client->API()->Reseller()->create(array('name' => $reseller_name.'2'));
		$resellers[] = $this->Client->API()->Reseller()->create(array('name' => $reseller_name.'3'));
		$resellers[] = $this->Client->API()->Reseller()->create(array('name' => $reseller_name.'4'));
		$resellers[] = $this->Client->API()->Reseller()->create(array('name' => $reseller_name.'5'));
		$resellers[] = $this->Client->API()->Reseller()->create(array('name' => $reseller_name.'6'));
		$result      = $this->Client->API()->Reseller()->offset(1)->limit(5)->fetchList();
		$this->assertIsArray($result);
		$this->assertTrue(count($result)==5)->addCommentary(print_r($result, 1));
		foreach ($resellers as $Reseller)
		{
			$Reseller->delete();
		}
	}

	public function testResellerPOST()
	{
		$reseller_name = 'test '.microtime(1);
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$this->assertTrue(is_object($Reseller));
		$this->assertEquals($Reseller->getName(), $reseller_name);
		$result = $this->Client->API()->Reseller()->filter(array('name' => $reseller_name))->fetchList();
		$this->assertIsArray($result);
		$Reseller->delete();
	}

	public function testContactResellerPOST()
	{
		$email = 'test@example.com';
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => 'test contactReseller '.microtime(1)));
		/** @var ContactReseller $ContactReseller */
		$Item = new ContactReseller($this->Client);
		$Item->setEmail($email);
		$Item->setReseller($Reseller->getResourceUri());
		$ContactReseller = $this->Client->API()->ContactReseller()->create($Item);
		$this->assertTrue(is_object($ContactReseller));
		$this->assertEquals($ContactReseller->getEmail(), $email);
		$ContactReseller->delete();
	}

	public function testResellerDELETE()
	{
		$reseller_name = 'test '.microtime(1).'_del';
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$this->assertTrue(is_object($Reseller));
		$this->assertEquals($Reseller->getName(), $reseller_name)->addCommentary(print_r($Reseller, 1));
		$result = $Reseller->delete();
		$this->assertTrue($result)->addCommentary(gettype($Reseller).': '.print_r($Reseller, 1));
		try
		{
			$result = $this->Client->API()->Reseller()->get($Reseller->getId());
		}
		catch (MailRouteException $E)
		{
			$result = false;
		}
		$this->assertTrue(!$result)->addCommentary(gettype($result).': '.print_r($result, 1));
	}

	public function testResellerPUT()
	{
		$reseller_name = 'test '.microtime(1).'_put';
		/** @var Reseller $Reseller */
		$NewReseller = new Reseller($this->Client);
		$NewReseller->setName($reseller_name);
		$Reseller = $this->Client->API()->Reseller()->create($NewReseller);
		$this->assertEquals($Reseller->getName(), $reseller_name);
		$Reseller->setName($reseller_name.'_updated');
		try
		{
			$Reseller = $this->Client->API()->Reseller()->update($Reseller);
		}
		catch (\Exception $E)
		{
			$this->assertTrue(false);
		}
		$this->assertEquals($Reseller->getName(), $reseller_name.'_updated', true);
		$Reseller->setName($reseller_name.'_saved');
		try
		{
			$Reseller->save();
		}
		catch (\Exception $E)
		{
			$this->assertTrue(false);
		}
		$Reseller = $this->Client->API()->Reseller()->get($Reseller->getId());
		$this->assertEquals($Reseller->getName(), $reseller_name.'_saved', true);
		$Reseller->delete();
	}

	public function testSearch()
	{
		$reseller_name = 'test '.microtime(1);
		/** @var IActiveEntity[] $resellers */
		$resellers   = array();
		$NewReseller = new Reseller($this->Client);
		$NewReseller->setName($reseller_name.'1');
		$resellers[] = $this->Client->API()->Reseller()->create($NewReseller);
		$NewReseller->setName($reseller_name.'2');
		$resellers[] = $this->Client->API()->Reseller()->create($NewReseller);
		$result      = $this->Client->API()->Reseller()->search($reseller_name);
		$this->assertIsArray($result);
		$this->assertIsObject($result[0]);
		foreach ($resellers as $Reseller)
		{
			$Reseller->delete();
		}
	}

	public function testCreateAdmin()
	{
		$reseller_name = 'test '.microtime(1).'create_admin';
		$NewReseller   = new Reseller($this->Client);
		$NewReseller->setName($reseller_name);
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create($NewReseller);
		try
		{
			$Admin = $Reseller->createAdmin('test@example.com', 'welcome');
		}
		catch (\Exception $E)
		{
			$this->assertTrue(false);
			//->addCommentary(print_r($this->Client->getRequestMock()->getLog(), 1))
			return false;
		}
		$this->assertIsObject($Admin);
		$this->assertEquals($Admin->getEmail(), 'test@example.com');
		$this->assertTrue($Reseller->delete());
	}
}
