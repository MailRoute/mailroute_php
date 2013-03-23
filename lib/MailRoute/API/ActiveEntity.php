<?php
namespace MailRoute\API;

class ActiveEntity implements IActiveEntity
{
	private $Entity;
	private $EntityHandler;
	private $EntityConverter;

	public function __call($method, $arguments)
	{
		return call_user_func_array(array($this->Entity, $method), $arguments);
	}

	public function __construct($Entity, EntityHandler $EntityHandler)
	{
		$this->Entity        = $Entity;
		$this->EntityHandler = $EntityHandler;
	}

	public function save()
	{
		$data = $this->getEntityConverter()->mapObjectToArray($this->Entity);
		if (empty($data['id']))
		{
			throw new MailRouteException("Can't save entity without ID", 400);
		}
		$result = $this->EntityHandler->callAPI('PUT', $data['id'], $data);
		return (!empty($result));
	}

	public function delete()
	{
		$data = $this->getEntityConverter()->mapObjectToArray($this->Entity);
		if (empty($data['id']))
		{
			throw new MailRouteException("Can't delete entity without ID", 400);
		}
		$result = $this->EntityHandler->delete($data['id']);
		return $result;
	}

	public function getEntityConverter()
	{
		if (empty($this->EntityConverter))
		{
			$this->EntityConverter = new EntityConverter();
		}
		return $this->EntityConverter;
	}

	public function setEntityConverter($EntityConverter)
	{
		$this->EntityConverter = $EntityConverter;
	}

	public function getEntity()
	{
		return $this->Entity;
	}

	public function setEntity($Entity)
	{
		$this->Entity = $Entity;
	}
}