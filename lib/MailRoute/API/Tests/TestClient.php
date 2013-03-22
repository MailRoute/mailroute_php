<?php
namespace MailRoute\API\Tests;

use Jamm\Tester\ClassTest;
use MailRoute\API\IClient;

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

	public function testReseller()
	{
		$result = $this->Client->API()->Reseller()->get('schema');
		$this->assertIsArray($result);
		$this->assertTrue(isset($result['allowed_detail_http_methods']));
	}

	public function testResellerList()
	{
		$reseller_name = 'test '.microtime(1);
		$resellers[]   = $this->Client->API()->Reseller()->create(array('name' => $reseller_name.'1'));
		$resellers[]   = $this->Client->API()->Reseller()->create(array('name' => $reseller_name.'2'));
		$resellers[]   = $this->Client->API()->Reseller()->create(array('name' => $reseller_name.'3'));
		$resellers[]   = $this->Client->API()->Reseller()->create(array('name' => $reseller_name.'4'));
		$resellers[]   = $this->Client->API()->Reseller()->create(array('name' => $reseller_name.'5'));
		$result        = $this->Client->API()->Reseller()->limit(5)->fetchList();
		$this->assertIsArray($result);
		$this->assertTrue(count($result)==5)->addCommentary(print_r($result, 1).
				print_r($this->Client->getRequestMock()->getLog(), 1));
		foreach ($resellers as $reseller)
		{
			$this->Client->API()->Reseller()->delete($reseller['id']);
		}
	}

	public function testResellerPOST()
	{
		$reseller_name = 'test '.microtime(1);
		$reseller      = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$this->assertIsArray($reseller);
		$this->assertEquals($reseller['name'], $reseller_name);
		$result = $this->Client->API()->Reseller()->filter(array('name' => $reseller_name))->fetchList();
		$this->assertIsArray($result);
		$this->Client->API()->Reseller()->delete($reseller['id']);
	}

	public function testResellerDELETE()
	{
		$reseller_name = 'test '.microtime(1).'_del';
		$reseller      = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$this->assertIsArray($reseller);
		$this->assertEquals($reseller['name'], $reseller_name)->addCommentary(print_r($reseller, 1));
		$result = $this->Client->API()->Reseller()->delete($reseller['id']);
		$this->assertTrue($result)->addCommentary(gettype($reseller).': '.print_r($reseller, 1));
		$result = $this->Client->API()->Reseller()->get($reseller['id']);
		$this->assertTrue(!$result)->addCommentary(gettype($result).': '.print_r($result, 1));
	}

	public function testResellerPUT()
	{
		$reseller_name = 'test '.microtime(1).'_put';
		$reseller      = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$this->assertEquals($reseller['name'], $reseller_name);
		$reseller['name'] = $reseller_name.'_updated';
		$reseller         = $this->Client->API()->Reseller()->update($reseller);
		$this->assertEquals($reseller['name'], $reseller_name.'_updated', true);
		$this->Client->API()->Reseller()->delete($reseller['id']);
	}
}
