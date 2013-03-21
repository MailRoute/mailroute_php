<?php
namespace MailRoute\API\Tests;

use Jamm\Tester\ClassTest;
use MailRoute\API\IClient;

class TestClient extends ClassTest
{
	/** @var IClient */
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
		$result = $this->Client->API()->Reseller()->GET('schema');
		$this->assertIsArray($result);
		$this->assertTrue(isset($result['allowed_detail_http_methods']));
	}

	public function testResellerList()
	{
		$reseller_name = 'test '.microtime(1);
		$this->Client->API()->Reseller()->POST(array('name' => $reseller_name.'1'));
		$this->Client->API()->Reseller()->POST(array('name' => $reseller_name.'2'));
		$this->Client->API()->Reseller()->POST(array('name' => $reseller_name.'3'));
		$this->Client->API()->Reseller()->POST(array('name' => $reseller_name.'4'));
		$this->Client->API()->Reseller()->POST(array('name' => $reseller_name.'5'));
		$result = $this->Client->API()->Reseller()->GET('', array(), 0, 5);
		$this->assertIsArray($result, $result);
		$this->assertTrue(count($result)==5);
	}

	public function testResellerPOST()
	{
		$reseller_name = 'test '.microtime(1);
		$result        = $this->Client->API()->Reseller()->POST(array('name' => $reseller_name));
		$this->assertTrue($result);
		$this->assertIsArray($result);
		$this->assertEquals($result['name'], $reseller_name);
		$result = $this->Client->API()->Reseller()->GET('', array('name' => $reseller_name));
		$this->assertIsArray($result);
	}

	public function testResellerDELETE()
	{
		$reseller_name = 'test '.microtime(1).'_del';
		$reseller      = $this->Client->API()->Reseller()->POST(array('name' => $reseller_name));
		$this->assertIsArray($reseller);
		$this->assertEquals($reseller['name'], $reseller_name)->addCommentary(print_r($reseller, 1));
		$result = $this->Client->API()->Reseller()->DELETE($reseller);
		$this->assertTrue($result);
		$result = $this->Client->API()->Reseller()->GET($reseller['id']);
		$this->assertTrue(!$result);
	}
}
