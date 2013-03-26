<?php
namespace MailRoute\API\Entity;

use MailRoute\API\MailRouteException;

class Reseller extends \MailRoute\API\ActiveEntity
{
	protected $api_entity_resource = 'reseller';
	protected $fields = array();
	/** @var Admins[] */
	private $admins;
	private $contacts;

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

	public function deleteAdmin($email)
	{
		if (!$this->getId())
		{
			throw new MailRouteException('This method requires ID');
		}
		$Admins = $this->getAdmins();
		foreach ($Admins as $Admin)
		{
			if ($Admin->getEmail()==$email)
			{
				try
				{
					$result = $this->Client->callAPI('admins/reseller/'.$this->getId().'/admin/'.$Admin->getId(), 'DELETE');
				}
				catch (MailRouteException $E)
				{
					if ($E->getCode()<>404)
					{
						throw $E;
					}
					return true;
				}
				return ($result!==false);
			}
		}
		return true;
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

	/**
	 * @return ContactReseller[]
	 */
	public function getContacts()
	{
		if (empty($this->contacts))
		{
			$Client         = $this->getAPIClient();
			$this->contacts = array();
			$contacts       = $Client->callAPI($this->getApiEntityResource().'/'.$this->getId().'/contacts', 'GET');
			if (!empty($contacts['objects']))
			{
				foreach ($contacts['objects'] as $contact_data)
				{
					$Contact = new ContactReseller($Client);
					$Contact->setAPIEntityFields($contact_data);
					$this->contacts[] = $Contact;
				}
			}
		}
		return $this->contacts;
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

	/**
	 * @return Admins[]
	 */
	public function getAdmins()
	{
		if ($this->admins===NULL)
		{
			$this->admins = $this->getAPIClient()->API()->Admins()->get($this->getApiEntityResource().'/'.$this->getId());
		}
		return $this->admins;
	}
}
