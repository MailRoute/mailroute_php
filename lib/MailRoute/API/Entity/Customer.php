<?php
namespace MailRoute\API\Entity;

use MailRoute\API\ActiveEntity;
use MailRoute\API\ValidationException;

class Customer extends ActiveEntity
{
	protected $api_entity_resource = 'customer';
	protected $fields = array();
	private $Reseller;
	private $domains;

	/**
	 * @param string $name
	 * @return Domain
	 */
	public function createDomain($name)
	{
		$Domain = new Domain($this->getAPIClient());
		$Domain->setCustomer($this->getResourceUri());
		$Domain->setName($name);
		return $this->getAPIClient()->API()->Domain()->create($Domain);
	}

	/**
	 * @param string $email
	 * @return ContactCustomer
	 */
	public function createContact($email)
	{
		$Contact = new ContactCustomer($this->getAPIClient());
		$Contact->setCustomer($this->getResourceUri());
		$Contact->setEmail($email);
		return $this->getAPIClient()->API()->ContactCustomer()->create($Contact);
	}

	public function deleteContact($email)
	{
		/** @var ContactCustomer[] $Contacts */
		$Contacts = $this->getAPIClient()->API()->ContactCustomer()->
				filter(array('email' => $email, 'customer' => $this->getId()))->fetchList();
		if (empty($Contacts))
		{
			return true;
		}
		$deleted = 0;
		foreach ($Contacts as $Contact)
		{
			$deleted += $Contact->delete();
		}
		return $deleted;
	}

	public function createAdmin($email, $send_welcome = false)
	{
		if (!$this->getId())
		{
			throw new ValidationException('This method requires ID');
		}
		$Admin = new Admins($this->getAPIClient());
		$Admin->setEmail($email);
		$Admin->setSendWelcome($send_welcome);
		$new_data = $this->getAPIClient()->callAPI($Admin->getApiEntityResource().'/'.$this->getApiEntityResource().'/'.$this->getId().'/',
			'POST', $Admin->getAPIEntityFields());
		$Admin->setAPIEntityFields($new_data);
		return $Admin;
	}

	public function deleteAdmin($email)
	{
		if (!$this->getId())
		{
			throw new ValidationException('This method requires ID');
		}
		$Admins = $this->getAdmins();
		foreach ($Admins as $Admin)
		{
			if ($Admin->getEmail()==$email)
			{
				return $Admin->delete();
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

	public function getBrandingInfo()
	{
		return parent::getBrandingInfo();
	}

	/**
	 * @return ContactCustomer[]
	 */
	public function getContacts()
	{
		return parent::getContacts(new ContactCustomer($this->getAPIClient()));
	}

	public function getCreatedAt()
	{
		return $this->fields['created_at'];
	}

	/**
	 * @return Domain[]
	 */
	public function getDomains()
	{
		if (empty($this->domains))
		{
			$Client        = $this->getAPIClient();
			$this->domains = array();
			$domains       = $Client->callAPI($this->getApiEntityResource().'/'.$this->getId().'/domains', 'GET');
			if (!empty($domains['objects']))
			{
				foreach ($domains['objects'] as $domain_data)
				{
					$Domain = new Domain($this->getAPIClient());
					$Domain->setAPIEntityFields($domain_data);
					$this->domains[] = $Domain;
				}
			}
		}
		return $this->domains;
		//return $this->fields['domains'];
	}

	public function getId()
	{
		return $this->fields['id'];
	}

	public function setId($id)
	{
		$this->fields['id'] = $id;
	}

	public function getIsFullUserList()
	{
		return $this->fields['is_full_user_list'];
	}

	public function setIsFullUserList($is_full_user_list)
	{
		$this->fields['is_full_user_list'] = $is_full_user_list;
	}

	public function getName()
	{
		return $this->fields['name'];
	}

	public function setName($name)
	{
		$this->fields['name'] = $name;
	}

	public function getReportedUserCount()
	{
		return $this->fields['reported_user_count'];
	}

	public function setReportedUserCount($reported_user_count)
	{
		$this->fields['reported_user_count'] = $reported_user_count;
	}

	public function getReseller()
	{
		if (empty($this->Reseller))
		{
			$data           = $this->getDataFromResourceURI($this->fields['reseller']);
			$this->Reseller = new Reseller($this->getAPIClient(), $data);
		}
		return $this->Reseller;
	}

	public function setReseller($reseller)
	{
		$this->fields['reseller'] = $reseller;
	}

	public function getUpdatedAt()
	{
		return $this->fields['updated_at'];
	}

	public function getAdmins()
	{
		return parent::getAdmins();
	}
}
