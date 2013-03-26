<?php
namespace MailRoute\API\Entity;

use MailRoute\API\MailRouteException;

class Reseller extends \MailRoute\API\ActiveEntity
{
	protected $api_entity_resource = 'reseller';
	protected $fields = array();

	/**
	 * @param $email
	 * @param $send_welcome
	 * @throws \MailRoute\API\MailRouteException
	 * @return Admins
	 */
	public function createAdmin($email, $send_welcome)
	{
		if (!$this->getId())
		{
			throw new MailRouteException('This method requires ID');
		}
		$Client = $this->getAPIClient();
		$Admin  = new Admins($Client);
		$Admin->setEmail($email);
		$Admin->setSendWelcome($send_welcome);
		$Admin->setReseller($Client->getAPIPathPrefix().$this->getApiEntityResource().'/'.$this->getId().'/');
		$new_data = $Client->callAPI('admins/reseller/'.$this->getId().'/', 'POST', $Admin->getAPIEntityFields());
		$Admin->setAPIEntityFields($new_data);
		return $Admin;
	}

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
