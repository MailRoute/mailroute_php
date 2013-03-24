<?php
namespace MailRoute\API\Entity;

/**
* @method save()
* @method delete()
*/
class LocalpartAlias
{
	private $created_at;
	private $domain;
	private $email_account;
	private $id;
	private $localpart;
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

	public function getEmailAccount()
	{
		return $this->email_account;
	}

	public function setEmailAccount($email_account)
	{
		$this->email_account = $email_account;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getLocalpart()
	{
		return $this->localpart;
	}

	public function setLocalpart($localpart)
	{
		$this->localpart = $localpart;
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
