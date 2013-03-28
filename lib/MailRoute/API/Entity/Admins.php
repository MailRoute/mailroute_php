<?php
namespace MailRoute\API\Entity;

class Admins extends \MailRoute\API\ActiveEntity
{
	protected $api_entity_resource = 'admins';
	protected $fields = array();

	public function getCustomer()
	{
		return $this->fields['customer'];
	}

	public function setCustomer($customer)
	{
		$this->fields['customer'] = $customer;
	}

	public function getDateJoined()
	{
		return $this->fields['date_joined'];
	}

	public function setDateJoined($date_joined)
	{
		$this->fields['date_joined'] = $date_joined;
	}

	public function getEmail()
	{
		return $this->fields['email'];
	}

	public function setEmail($email)
	{
		$this->fields['email'] = $email;
	}

	public function getId()
	{
		return $this->fields['id'];
	}

	public function setId($id)
	{
		$this->fields['id'] = $id;
	}

	public function getIsActive()
	{
		return $this->fields['is_active'];
	}

	public function setIsActive($is_active)
	{
		$this->fields['is_active'] = $is_active;
	}

	public function getLastLogin()
	{
		return $this->fields['last_login'];
	}

	public function setLastLogin($last_login)
	{
		$this->fields['last_login'] = $last_login;
	}

	public function getReseller()
	{
		return $this->fields['reseller'];
	}

	public function setReseller($reseller)
	{
		$this->fields['reseller'] = $reseller;
	}

	public function getResourceUri()
	{
		return $this->fields['resource_uri'];
	}

	public function getSendWelcome()
	{
		return $this->fields['send_welcome'];
	}

	public function setSendWelcome($send_welcome)
	{
		$this->fields['send_welcome'] = $send_welcome;
	}

	public function getUsername()
	{
		return $this->fields['username'];
	}

	public function setUsername($username)
	{
		$this->fields['username'] = $username;
	}

	public function delete()
	{
		return $this->getAPIClient()->callAPI($this->getResourceUri(), 'DELETE');
	}
}
