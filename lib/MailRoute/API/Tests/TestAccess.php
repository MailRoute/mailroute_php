<?php
namespace MailRoute\API\Tests;

use Jamm\Tester\ClassTest;
use MailRoute\API\Config;
use MailRoute\API\IClient;

class TestAccess extends ClassTest
{
	/** @var Config */
	private $RootConfig;
	/** @var IClient */
	private $RootClient;
	/** @var Config */
	private $InitialConfig;

	public function __construct(Config $Config)
	{
		$this->InitialConfig = $Config;
	}

	public function setUp()
	{
		$this->RootConfig = $this->InitialConfig;
		$this->RootClient = new ClientMock($this->RootConfig);
	}

	public function testResellerAccess()
	{
		$Reseller = $this->RootClient->API()->Reseller()->create(array('name' => 'reseller'.md5(microtime(1).mt_rand(1, 9999))));
		$Config   = clone $this->RootConfig;
	}
}
