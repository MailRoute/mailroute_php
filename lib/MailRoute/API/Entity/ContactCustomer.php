<?php
namespace MailRoute\API\Entity;

class ContactCustomer
{
	private $address;
	private $address2;
	private $city;
	private $country;
	private $created_at;
	private $customer;
	private $email;
	private $first_name;
	private $id;
	private $is_billing;
	private $is_emergency;
	private $is_technical;
	private $last_name;
	private $phone;
	private $resource_uri;
	private $state;
	private $updated_at;
	private $zipcode;

	public function getAddress()
	{
		return $this->address;
	}

	public function setAddress($address)
	{
		$this->address = $address;
	}

	public function getAddress2()
	{
		return $this->address2;
	}

	public function setAddress2($address2)
	{
		$this->address2 = $address2;
	}

	public function getCity()
	{
		return $this->city;
	}

	public function setCity($city)
	{
		$this->city = $city;
	}

	public function getCountry()
	{
		return $this->country;
	}

	public function setCountry($country)
	{
		$this->country = $country;
	}

	public function getCreatedAt()
	{
		return $this->created_at;
	}

	public function getCustomer()
	{
		return $this->customer;
	}

	public function setCustomer($customer)
	{
		$this->customer = $customer;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function getFirstName()
	{
		return $this->first_name;
	}

	public function setFirstName($first_name)
	{
		$this->first_name = $first_name;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getIsBilling()
	{
		return $this->is_billing;
	}

	public function setIsBilling($is_billing)
	{
		$this->is_billing = $is_billing;
	}

	public function getIsEmergency()
	{
		return $this->is_emergency;
	}

	public function setIsEmergency($is_emergency)
	{
		$this->is_emergency = $is_emergency;
	}

	public function getIsTechnical()
	{
		return $this->is_technical;
	}

	public function setIsTechnical($is_technical)
	{
		$this->is_technical = $is_technical;
	}

	public function getLastName()
	{
		return $this->last_name;
	}

	public function setLastName($last_name)
	{
		$this->last_name = $last_name;
	}

	public function getPhone()
	{
		return $this->phone;
	}

	public function setPhone($phone)
	{
		$this->phone = $phone;
	}

	public function getResourceUri()
	{
		return $this->resource_uri;
	}

	public function getState()
	{
		return $this->state;
	}

	public function setState($state)
	{
		$this->state = $state;
	}

	public function getUpdatedAt()
	{
		return $this->updated_at;
	}

	public function getZipcode()
	{
		return $this->zipcode;
	}

	public function setZipcode($zipcode)
	{
		$this->zipcode = $zipcode;
	}

}
