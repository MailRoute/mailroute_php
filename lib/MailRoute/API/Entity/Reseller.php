<?php
namespace MailRoute\API\Entity;

/**
* @method save()
* @method delete()
*/
class Reseller
{
	private $allow_branding;
	private $allow_customer_branding;
	private $branding_info;
	private $contacts;
	private $created_at;
	private $customers;
	private $id;
	private $name;
	private $resource_uri;
	private $updated_at;

	public function getAllowBranding()
	{
		return $this->allow_branding;
	}

	public function setAllowBranding($allow_branding)
	{
		$this->allow_branding = $allow_branding;
	}

	public function getAllowCustomerBranding()
	{
		return $this->allow_customer_branding;
	}

	public function setAllowCustomerBranding($allow_customer_branding)
	{
		$this->allow_customer_branding = $allow_customer_branding;
	}

	public function getBrandingInfo()
	{
		return $this->branding_info;
	}

	public function getContacts()
	{
		return $this->contacts;
	}

	public function getCreatedAt()
	{
		return $this->created_at;
	}

	public function getCustomers()
	{
		return $this->customers;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function getResourceUri()
	{
		return $this->resource_uri;
	}

	public function getUpdatedAt()
	{
		return $this->updated_at;
	}

}
