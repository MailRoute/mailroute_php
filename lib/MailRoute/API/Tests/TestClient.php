<?php
namespace MailRoute\API\Tests;

use Jamm\Tester\ClassTest;
use MailRoute\API\Entity\ContactReseller;
use MailRoute\API\Entity\Customer;
use MailRoute\API\Entity\Domain;
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

	public function testCreateAndDeleteAdmin()
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
		$this->assertTrue($Reseller->deleteAdmin('test@example.com'));
		$this->assertTrue($Reseller->delete());
	}

	public function testResellerGetContacts()
	{
		$reseller_name = 'test '.microtime(1).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		for ($i = 0; $i < 5; $i++)
		{
			$ContactReseller = $this->Client->API()->ContactReseller()->create(array(
				'reseller' => $this->Client->getAPIPathPrefix().$Reseller->getApiEntityResource().'/'.$Reseller->getId().'/',
				'email'    => 'reseller_contact@example.com'
			));
		}
		$Contacts = $Reseller->getContacts();
		$this->assertIsArray($Contacts);
		$this->assertIsObject($Contacts[0]);
		foreach ($Contacts as $Contact)
		{
			$this->assertTrue($Contact->delete());
		}
		$this->assertTrue($Reseller->delete());
	}

	public function testResellerCreateContact()
	{
		$reseller_name = 'test '.microtime(1).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$result   = $Reseller->createContact('contact@example.com');
		$this->assertIsObject($result);
		$this->assertEquals($result->getEmail(), 'contact@example.com');
		$this->assertTrue($result->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testResellerCreateCustomer()
	{
		$reseller_name = 'test '.microtime(1).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$result   = $Reseller->createCustomer('customer'.$reseller_name);
		$this->assertIsObject($result);
		$this->assertEquals($result->getName(), 'customer'.$reseller_name);
		$this->assertTrue($result->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testCustomerCreateContact()
	{
		$reseller_name = 'test '.microtime(1).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer = $Reseller->createCustomer('customer'.$reseller_name);
		$result   = $Customer->createContact('customer@example.com');
		$this->assertIsObject($result);
		$this->assertEquals($result->getEmail(), 'customer@example.com');
		$this->assertTrue($result->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testCustomerCreateAdmin()
	{
		$reseller_name = 'test '.microtime(1).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer = $Reseller->createCustomer('customer'.$reseller_name);
		$result   = $Customer->createAdmin('admin_customer@example.com');
		$this->assertIsObject($result);
		$this->assertEquals($result->getEmail(), 'admin_customer@example.com');
		$this->assertTrue($result->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testCustomerDeleteAdmin()
	{
		$reseller_name = 'test '.microtime(1).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller  = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer  = $Reseller->createCustomer('customer'.$reseller_name);
		$adm_email = 'admin_customer'.md5($reseller_name).'@example.com';
		$Customer->createAdmin($adm_email);
		$Customer->createAdmin('2'.$adm_email);
		$result = $Customer->deleteAdmin($adm_email);
		$this->assertTrueStrict($result);
		/** @var Customer $RefreshCustomer */
		$RefreshCustomer = $this->Client->API()->Customer()->get($Customer->getId());
		$new_list        = $RefreshCustomer->getAdmins();
		$this->assertEquals(count($new_list), 1, true);
		$this->assertEquals($new_list[0]->getEmail(), '2'.$adm_email);
		$this->assertTrue($new_list[0]->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testCustomerCreateDomain()
	{
		$reseller_name = 'test '.microtime(1).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer = $Reseller->createCustomer('customer'.$reseller_name);
		$d        = 'domain'.md5(microtime(1).__LINE__).'.name';
		$result   = $Customer->createDomain($d);
		$this->assertIsObject($result);
		$this->assertEquals($result->getName(), $d);
		$this->assertTrue($result->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testDomainMoveToCustomer()
	{
		$reseller_name = 'test '.microtime(1).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller  = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer1 = $Reseller->createCustomer('customer1'.$reseller_name);
		$Customer2 = $Reseller->createCustomer('customer2'.$reseller_name);
		$Domain    = $Customer1->createDomain('domain'.md5(microtime(1).__LINE__).'.name');
		$this->assertEquals($Domain->getCustomer(), $Customer1->getResourceUri());
		$this->assertEquals($Domain->getCustomer(), $Customer1->getResourceUri());
		$result = $Domain->moveToCustomer($Customer2);
		$this->assertTrueStrict($result);
		/** @var Domain $FreshDomain */
		$FreshDomain = $this->Client->API()->Domain()->get($Domain->getId());
		$this->assertEquals($FreshDomain->getCustomer(), $Customer2->getResourceUri());
		$Domain->delete();
		$Customer2->delete();
		$Customer1->delete();
		$Reseller->delete();
	}

	public function testDomainCreateContact()
	{
		$reseller_name = 'test '.microtime(1).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain   = $Customer->createDomain('domain'.md5(microtime(1).__LINE__).'.name');

		$email  = 'domain.contact.'.md5($Domain->getResourceUri()).'@example.com';
		$result = $Domain->createContact($email);
		$this->assertIsObject($result);
		$this->assertEquals($result->getEmail(), $email);
		$this->assertTrue($result->delete());
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testDomainCreateMailServer()
	{
		$reseller_name = 'test '.microtime(1).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain   = $Customer->createDomain('domain'.md5(microtime(1).__LINE__).'.name');

		$result = $Domain->createMailServer('127.0.0.1');
		$this->assertIsObject($result);
		$this->assertEquals($result->getServer(), '127.0.0.1');
		$this->assertTrue($result->delete());
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}
}
