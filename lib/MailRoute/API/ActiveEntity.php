<?php
namespace MailRoute\API;

class ActiveEntity
{
	private $Entity;
	private $Client;

	public function __call($method, $arguments)
	{
		return call_user_func_array(array($this->Entity, $method), $arguments);
	}

	public function __construct($Entity, $Client)
	{
		$this->Entity = $Entity;
		$this->Client = $Client;
	}
}