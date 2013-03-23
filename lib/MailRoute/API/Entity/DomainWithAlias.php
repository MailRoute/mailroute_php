<?php
namespace MailRoute\API\Entity;

class DomainWithAlias
{
	private $created_at;
	private $domain;
	private $id;
	private $name;
	private $resource_uri;
	private $type;
	private $updated_at;

	public function getCreatedAt()
	{
		return $this->created_at;
	}

	public function getDomain()
	{
		return $this->domain;
	}

	public function setDomain($domain)
	{
		$this->domain = $domain;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function getResourceUri()
	{
		return $this->resource_uri;
	}

	public function getType()
	{
		return $this->type;
	}

	public function setType($type)
	{
		$this->type = $type;
	}

	public function getUpdatedAt()
	{
		return $this->updated_at;
	}

}
