<?php
namespace MailRoute\API\Entity;

/**
* @method save()
* @method delete()
*/
class DomainAlias
{
	private $active;
	private $created_at;
	private $domain;
	private $id;
	private $name;
	private $resource_uri;
	private $updated_at;

	public function getActive()
	{
		return $this->active;
	}

	public function setActive($active)
	{
		$this->active = $active;
	}

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

	public function getUpdatedAt()
	{
		return $this->updated_at;
	}

}
