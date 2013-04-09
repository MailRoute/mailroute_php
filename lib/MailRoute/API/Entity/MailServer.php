<?php
namespace MailRoute\API\Entity;

class MailServer extends \MailRoute\API\ActiveEntity
{
	protected $api_entity_resource = 'mail_server';
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

	public function getPriority()
	{
		return $this->fields['priority'];
	}

	public function setPriority($priority)
	{
		$this->fields['priority'] = $priority;
	}

	public function getSaslLogin()
	{
		return $this->fields['sasl_login'];
	}

	public function setSaslLogin($sasl_login)
	{
		$this->fields['sasl_login'] = $sasl_login;
	}

	public function getSaslPassword()
	{
		return $this->fields['sasl_password'];
	}

	public function setSaslPassword($sasl_password)
	{
		$this->fields['sasl_password'] = $sasl_password;
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

	public function getUseSasl()
	{
		return $this->fields['use_sasl'];
	}

	public function setUseSasl($use_sasl)
	{
		$this->fields['use_sasl'] = $use_sasl;
	}

}
