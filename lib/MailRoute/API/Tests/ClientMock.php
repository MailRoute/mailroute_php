<?php
namespace MailRoute\API\Tests;

use MailRoute\API\Client;

class ClientMock extends Client
{
	private $Request;

	protected function getNewRequest()
	{
		$this->Request = new RequestMock();
		return $this->Request;
	}

	/**
	 * @return RequestMock
	 */
	public function getRequestMock()
	{
		return $this->Request;
	}

	public function getResponse()
	{
		return parent::getResponse();
	}
}
