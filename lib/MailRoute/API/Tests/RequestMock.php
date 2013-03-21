<?php
namespace MailRoute\API\Tests;

use Jamm\HTTP\Request;

class RequestMock extends Request
{
	private $log;

	protected function writeToConnection($data)
	{
		$this->log[] = $data;
		return parent::writeToConnection($data);
	}

	public function getLog()
	{
		$log       = $this->log;
		$this->log = array();
		return $log;
	}
}
