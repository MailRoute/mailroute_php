<?php
namespace MailRoute\API;

abstract class ActiveEntity implements IActiveEntity
{
	protected $api_entity_resource = '';
	protected $fields = array();
	protected $Client;

	public function __construct(IClient $Client)
	{
		$this->Client = $Client;
	}

	public function save()
	{
		$data = $this->getAPIEntityFields();
		if (empty($data['id']))
		{
			throw new MailRouteException("Can't save entity without ID", 400);
		}
		$result = $this->Client->callAPI($this->getApiEntityResource().'/'.$data['id'], 'PUT', $data);
		return (!empty($result));
	}

	public function delete()
	{
		$data = $this->getAPIEntityFields();
		if (empty($data['id']))
		{
			throw new MailRouteException("Can't delete entity without ID", 400);
		}
		try
		{
			$result = $this->Client->callAPI($this->getApiEntityResource().'/'.$data['id'], 'DELETE');
		}
		catch (MailRouteException $E)
		{
			if ($E->getCode() > 299 && $E->getCode()<>404)
			{
				throw $E;
			}
			return false;
		}
		return $result!==false;
	}

	public function getApiEntityResource()
	{
		return $this->api_entity_resource;
	}

	public function setApiEntityResource($api_entity_resource)
	{
		$this->api_entity_resource = $api_entity_resource;
	}

	public function getAPIClient()
	{
		return $this->Client;
	}

	public function setAPIClient(IClient $Client)
	{
		$this->Client = $Client;
	}

	public function getAPIEntityFields()
	{
		return $this->fields;
	}

	public function setAPIEntityFields(array $fields)
	{
		$this->fields = $fields;
	}
}