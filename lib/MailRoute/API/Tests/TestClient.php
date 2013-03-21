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

	public function testResellerPOST()
	{
		$result = $this->Client->API()->Reseller()->POST(array('name' => 'test_reseller', 'resource_uri' => 'https://github.com/MailRoute/mailroute_php_new'));
		$this->assertTrue($result)->addCommentary(print_r($this->Client->getRequestMock()->getLog(), 1));
		$result = $this->Client->API()->Reseller()->GET('', array('name' => 'test_reseller'));
		$this->assertEquals($result, '.')->addCommentary(print_r($this->Client->getRequestMock()->getLog(), 1));
		;
	}
}
