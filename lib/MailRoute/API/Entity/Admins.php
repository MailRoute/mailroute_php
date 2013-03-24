<?php
namespace MailRoute\API\Entity;

/**
* @method save()
* @method delete()
*/
class Admins
{
	private $customer;
	private $date_joined;
	private $email;
	private $id;
	private $is_active;
	private $last_login;
	private $reseller;
	private $resource_uri;
	private $send_welcome;
	private $username;

	public function getCustomer()
	{
		return $this->customer;
	}

	public function setCustomer($customer)
	{
		$this->customer = $customer;
	}

	public function getDateJoined()
	{
		return $this->date_joined;
	}

	public function setDateJoined($date_joined)
	{
		$this->date_joined = $date_joined;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getIsActive()
	{
		return $this->is_active;
	}

	public function setIsActive($is_active)
	{
		$this->is_active = $is_active;
	}

	public function getLastLogin()
	{
		return $this->last_login;
	}

	public function setLastLogin($last_login)
	{
		$this->last_login = $last_login;
	}

	public function getReseller()
	{
		return $this->reseller;
	}

	public function setReseller($reseller)
	{
		$this->reseller = $reseller;
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

	public function getUsername()
	{
		return $this->username;
	}

	public function setUsername($username)
	{
		$this->username = $username;
	}

}
