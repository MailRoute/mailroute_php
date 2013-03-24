<?php
namespace MailRoute\API\Entity;

/**
* @method save()
* @method delete()
*/
class MailServer
{
	private $created_at;
	private $domain;
	private $id;
	private $priority;
	private $resource_uri;
	private $sasl_login;
	private $sasl_password;
	private $server;
	private $updated_at;
	private $use_sasl;

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

	public function getPriority()
	{
		return $this->priority;
	}

	public function setPriority($priority)
	{
		$this->priority = $priority;
	}

	public function getResourceUri()
	{
		return $this->resource_uri;
	}

	public function getSaslLogin()
	{
		return $this->sasl_login;
	}

	public function setSaslLogin($sasl_login)
	{
		$this->sasl_login = $sasl_login;
	}

	public function getSaslPassword()
	{
		return $this->sasl_password;
	}

	public function setSaslPassword($sasl_password)
	{
		$this->sasl_password = $sasl_password;
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

	public function getUseSasl()
	{
		return $this->use_sasl;
	}

	public function setUseSasl($use_sasl)
	{
		$this->use_sasl = $use_sasl;
	}

}
