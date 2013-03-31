<?php
namespace MailRoute\API;

abstract class ActiveEntity implements IActiveEntity
{
	protected $api_entity_resource = '';
	protected $fields = array();
	protected $Client;

	public function __construct(IClient $Client, array $data = array())
	{
		$this->Client = $Client;
		if (!empty($data))
		{
			$this->setAPIEntityFields($data);
		}
	}

	public function save()
	{
		$data = $this->getAPIEntityFields();
		if (empty($data['id']))
		{
			throw new ValidationException("Can't save entity without ID", 400);
		}
		$result = $this->Client->callAPI($this->getApiEntityResource().'/'.$data['id'], 'PUT', $data);
		return (!empty($result));
	}

	public function delete()
	{
		$data = $this->getAPIEntityFields();
		if (empty($data['id']))
		{
			throw new ValidationException("Can't delete entity without ID", 400);
		}
		return $this->Client->callAPI($this->getApiEntityResource().'/'.$data['id'], 'DELETE');
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

	public function getResourceUri()
	{
		if (empty($this->fields['resource_uri']))
		{
			$this->fields['resource_uri'] = $this->getAPIClient()->getAPIPathPrefix().$this->getApiEntityResource().'/'.$this->getId().'/';
		}
		return $this->fields['resource_uri'];
	}

	protected function getId()
	{
		return $this->fields['id'];
	}
}
