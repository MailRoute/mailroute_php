<?php
namespace MailRoute\API\Entity;

class Reseller extends \MailRoute\API\ActiveEntity
{
	protected $api_entity_resource = 'reseller';
	protected $fields = array('allow_branding', 'allow_customer_branding', 'branding_info', 'contacts', 'created_at', 'customers', 'id', 'name', 'resource_uri', 'updated_at');

	public function getAllowBranding()
	{
		return $this->fields['allow_branding'];
	}

	public function setAllowBranding($allow_branding)
	{
		$this->fields['allow_branding'] = $allow_branding;
	}

	public function getAllowCustomerBranding()
	{
		return $this->fields['allow_customer_branding'];
	}

	public function setAllowCustomerBranding($allow_customer_branding)
	{
		$this->fields['allow_customer_branding'] = $allow_customer_branding;
	}

	public function getBrandingInfo()
	{
		return $this->fields['branding_info'];
	}

	public function getContacts()
	{
		return $this->fields['contacts'];
	}

	public function getCreatedAt()
	{
		return $this->fields['created_at'];
	}

	public function getCustomers()
	{
		return $this->fields['customers'];
	}

	public function getId()
	{
		return $this->fields['id'];
	}

	public function setId($id)
	{
		$this->fields['id'] = $id;
	}

	public function getName()
	{
		return $this->fields['name'];
	}

	public function setName($name)
	{
		$this->fields['name'] = $name;
	}

	public function getResourceUri()
	{
		return $this->fields['resource_uri'];
	}

	public function getUpdatedAt()
	{
		return $this->fields['updated_at'];
	}

}
