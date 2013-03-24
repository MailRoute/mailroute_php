<?php
namespace MailRoute\API\Entity;

/**
* @method save()
* @method delete()
*/
class EmailAccount
{
	private $change_pwd;
	private $confirm_password;
	private $contact;
	private $create_opt;
	private $created_at;
	private $domain;
	private $id;
	private $localpart;
	private $localpart_aliases;
	private $notification_task;
	private $password;
	private $policy;
	private $priority;
	private $resource_uri;
	private $send_welcome;
	private $updated_at;

	public function getChangePwd()
	{
		return $this->change_pwd;
	}

	public function setChangePwd($change_pwd)
	{
		$this->change_pwd = $change_pwd;
	}

	public function getConfirmPassword()
	{
		return $this->confirm_password;
	}

	public function setConfirmPassword($confirm_password)
	{
		$this->confirm_password = $confirm_password;
	}

	public function getContact()
	{
		return $this->contact;
	}

	public function getCreateOpt()
	{
		return $this->create_opt;
	}

	public function setCreateOpt($create_opt)
	{
		$this->create_opt = $create_opt;
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

	public function getLocalpart()
	{
		return $this->localpart;
	}

	public function setLocalpart($localpart)
	{
		$this->localpart = $localpart;
	}

	public function getLocalpartAliases()
	{
		return $this->localpart_aliases;
	}

	public function getNotificationTask()
	{
		return $this->notification_task;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function setPassword($password)
	{
		$this->password = $password;
	}

	public function getPolicy()
	{
		return $this->policy;
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

	public function getSendWelcome()
	{
		return $this->send_welcome;
	}

	public function setSendWelcome($send_welcome)
	{
		$this->send_welcome = $send_welcome;
	}

	public function getUpdatedAt()
	{
		return $this->updated_at;
	}

}
