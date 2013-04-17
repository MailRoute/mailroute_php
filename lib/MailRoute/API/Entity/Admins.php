<?php
namespace MailRoute\API\Entity;

class Admins extends \MailRoute\API\ActiveEntity
{
	protected $api_entity_resource = 'admins';
	protected $fields = array();

	public function getCustomer()
	{
		if (empty($this->Customer) && empty($this->fields['customer']))
		{
			$elements = explode('/', substr($this->fields['resource_uri'], strlen($this->getAPIClient()->getAPIPathPrefix())));
			if (isset($elements[1]) && $elements[1]=='customer' && !empty($elements[2]))
			{
				$this->Customer = $this->getAPIClient()->API()->Customer()->get($elements[2]);
			}
		}
		return parent::getCustomer();
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
		$this->fields['id'] = substr($this->fields['resource_uri'],
				strlen($this->getAPIClient()->getAPIPathPrefix())+strlen($this->getApiEntityResource())+1);
		return $this->fields['id'];
	}

	public function setId($id)
	{
		$this->fields['id'] = $id;
	}

	public function regenerateApiKey()
	{
		$result = $this->getAPIClient()->callAPI($this->getApiEntityResource().'/'.$this->getId().'/regenerate_api_key', 'POST');
		return (isset($result['api_key']) ? $result['api_key'] : $result);
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
		if (empty($this->Reseller) && empty($this->fields['reseller']))
		{
			$elements = explode('/', substr($this->fields['resource_uri'], strlen($this->getAPIClient()->getAPIPathPrefix())));
			if (isset($elements[1]) && $elements[1]=='reseller' && !empty($elements[2]))
			{
				$this->Reseller = $this->getAPIClient()->API()->Reseller()->get($elements[2]);
			}
		}
		return parent::getReseller();
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
		$resource_path = substr($this->getResourceUri(), strlen($this->getAPIClient()->getAPIPathPrefix()));
		return $this->getAPIClient()->callAPI($resource_path, 'DELETE');
	}
}
