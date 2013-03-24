<?php
namespace MailRoute\API\Entity;

/**
* @method save()
* @method delete()
*/
class OutboundServer
{
	private $created_at;
	private $domain;
	private $id;
	private $resource_uri;
	private $server;
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

	public function getResourceUri()
	{
		return $this->resource_uri;
	}

	public function getServer()
	{
		return $this->server;
	}

	public function setServer($server)
	{
		$this->server = $server;
	}

	public function getUpdatedAt()
	{
		return $this->updated_at;
	}

}
