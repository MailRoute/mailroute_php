<?php
namespace MailRoute\API;

class EntityHandler
{
	private $entity_name;
	private $Client;

	public function __construct(IClient $Client)
	{
		$this->Client = $Client;
	}

	public function __call($function, $arguments)
	{
		if (empty($this->entity_name))
		{
			$this->entity_name = $function;
			return $this;
		}
		$method           = $function;
		$url_request_part = '/'.$this->entity_name.'/';
		if ($method=='GET' && !empty($arguments))
		{
			$id = array_shift($arguments);
			$url_request_part .= $id;
		}
		return $this->Client->callAPI($url_request_part, $method, $arguments);
	}

	public function setEntityName($entity_name)
	{
		$this->entity_name = $entity_name;
	}
}
