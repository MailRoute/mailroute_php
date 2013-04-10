<?php
namespace MailRoute\API\Entity;

class ContactEmailAccount extends \MailRoute\API\ActiveEntity
{
	protected $api_entity_resource = 'contact_email_account';
	protected $fields = array();

	public function getAddress()
	{
		return $this->fields['address'];
	}

	public function setAddress($address)
	{
		$this->fields['address'] = $address;
	}

	public function getAddress2()
	{
		return $this->fields['address2'];
	}

	public function setAddress2($address2)
	{
		$this->fields['address2'] = $address2;
	}

	public function getCity()
	{
		return $this->fields['city'];
	}

	public function setCity($city)
	{
		$this->fields['city'] = $city;
	}

	public function getCountry()
	{
		return $this->fields['country'];
	}

	public function setCountry($country)
	{
		$this->fields['country'] = $country;
	}

	public function getCreatedAt()
	{
		return $this->fields['created_at'];
	}

	public function getEmail()
	{
		return $this->fields['email'];
	}

	public function setEmail($email)
	{
		$this->fields['email'] = $email;
	}

	public function getEmailAccount()
	{
		return parent::getEmailAccount();
	}

	public function setEmailAccount($email_account)
	{
		$this->fields['email_account'] = $email_account;
	}

	public function getFirstName()
	{
		return $this->fields['first_name'];
	}

	public function setFirstName($first_name)
	{
		$this->fields['first_name'] = $first_name;
	}

	public function getId()
	{
		return $this->fields['id'];
	}

	public function setId($id)
	{
		$this->fields['id'] = $id;
	}

	public function getIsBilling()
	{
		return $this->fields['is_billing'];
	}

	public function setIsBilling($is_billing)
	{
		$this->fields['is_billing'] = $is_billing;
	}

	public function getIsEmergency()
	{
		return $this->fields['is_emergency'];
	}

	public function setIsEmergency($is_emergency)
	{
		$this->fields['is_emergency'] = $is_emergency;
	}

	public function getIsTechnical()
	{
		return $this->fields['is_technical'];
	}

	public function setIsTechnical($is_technical)
	{
		$this->fields['is_technical'] = $is_technical;
	}

	public function getLastName()
	{
		return $this->fields['last_name'];
	}

	public function setLastName($last_name)
	{
		$this->fields['last_name'] = $last_name;
	}

	public function getPhone()
	{
		return $this->fields['phone'];
	}

	public function setPhone($phone)
	{
		$this->fields['phone'] = $phone;
	}

	public function getState()
	{
		return $this->fields['state'];
	}

	public function setState($state)
	{
		$this->fields['state'] = $state;
	}

	public function getUpdatedAt()
	{
		return $this->fields['updated_at'];
	}

	public function getZipcode()
	{
		return $this->fields['zipcode'];
	}

	public function setZipcode($zipcode)
	{
		$this->fields['zipcode'] = $zipcode;
	}

}
