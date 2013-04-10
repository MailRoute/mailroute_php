<?php
namespace MailRoute\API\Entity;

class OutboundServer extends \MailRoute\API\ActiveEntity
{
	protected $api_entity_resource = 'outbound_server';
	protected $fields = array();

	public function getCreatedAt()
	{
		return $this->fields['created_at'];
	}

	public function getDomain()
	{
		return parent::getDomain();
	}

	public function setDomain($domain)
	{
		$this->fields['domain'] = $domain;
	}

	public function getId()
	{
		return $this->fields['id'];
	}

	public function setId($id)
	{
		$this->fields['id'] = $id;
	}

	public function getServer()
	{
		return $this->fields['server'];
	}

	public function setServer($server)
	{
		$this->fields['server'] = $server;
	}

	public function getUpdatedAt()
	{
		return $this->fields['updated_at'];
	}

}
