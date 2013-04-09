<?php
namespace MailRoute\API\Entity;

class DomainAlias extends \MailRoute\API\ActiveEntity
{
	protected $api_entity_resource = 'domain_alias';
	protected $fields = array();

	public function getActive()
	{
		return $this->fields['active'];
	}

	public function setActive($active)
	{
		$this->fields['active'] = $active;
	}

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

	public function getName()
	{
		return $this->fields['name'];
	}

	public function setName($name)
	{
		$this->fields['name'] = $name;
	}

	public function getUpdatedAt()
	{
		return $this->fields['updated_at'];
	}

}
