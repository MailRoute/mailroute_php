<?php
namespace MailRoute\API\Entity;

class Wblist extends \MailRoute\API\ActiveEntity
{
	protected $api_entity_resource = 'wblist';
	protected $fields = array();

	public function getDomain()
	{
		return $this->fields['domain'];
	}

	public function setDomain($domain)
	{
		$this->fields['domain'] = $domain;
	}

	public function getEmailAccount()
	{
		return $this->fields['email_account'];
	}

	public function setEmailAccount($email_account)
	{
		$this->fields['email_account'] = $email_account;
	}

	public function getId()
	{
		return $this->fields['id'];
	}

	public function setId($id)
	{
		$this->fields['id'] = $id;
	}

	public function getResourceUri()
	{
		return $this->fields['resource_uri'];
	}

	public function getWb()
	{
		return $this->fields['wb'];
	}

	public function setWb($wb)
	{
		$this->fields['wb'] = $wb;
	}

}
