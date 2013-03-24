<?php
namespace MailRoute\API\Entity;

/**
* @method save()
* @method delete()
*/
class Wblist
{
	private $domain;
	private $email_account;
	private $id;
	private $resource_uri;
	private $wb;

	public function getDomain()
	{
		return $this->domain;
	}

	public function setDomain($domain)
	{
		$this->domain = $domain;
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

	public function getResourceUri()
	{
		return $this->resource_uri;
	}

	public function getWb()
	{
		return $this->wb;
	}

	public function setWb($wb)
	{
		$this->wb = $wb;
	}

}
