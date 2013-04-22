<?php
namespace MailRoute\API;

use MailRoute\API\Entity\Admins;
use MailRoute\API\Entity\Brandinginfo;
use MailRoute\API\Entity\Customer;
use MailRoute\API\Entity\Domain;
use MailRoute\API\Entity\EmailAccount;
use MailRoute\API\Entity\NotificationAccountTask;
use MailRoute\API\Entity\NotificationDomainTask;
use MailRoute\API\Entity\Reseller;

abstract class ActiveEntity implements IActiveEntity
{
	protected $api_entity_resource = '';
	protected $fields = array();
	protected $Client;
	protected $BrandingInfo;
	protected $contacts;
	protected $admins;
	protected $Domain;
	protected $EmailAccount;
	protected $Reseller;
	protected $Customer;
	protected $notification_tasks;

	public function __construct(IClient $Client, array $data = array())
	{
		$this->Client = $Client;
		if (!empty($data))
		{
			$this->setAPIEntityFields($data);
		}
	}

	public function save()
	{
		$id = $this->getId();
		if (empty($id))
		{
			throw new ValidationException("Can't save entity without ID", 400);
		}
		$result = $this->Client->callAPI($this->getApiEntityResource().'/'.$id, 'PUT', $this->getAPIEntityFields());
		return (!empty($result));
	}

	public function delete()
	{
		$id = $this->getId();
		if (empty($id))
		{
			throw new ValidationException("Can't delete entity without ID", 400);
		}
		return $this->Client->callAPI($this->getApiEntityResource().'/'.$id, 'DELETE');
	}

	public function getApiEntityResource()
	{
		return $this->api_entity_resource;
	}

	public function setApiEntityResource($api_entity_resource)
	{
		$this->api_entity_resource = $api_entity_resource;
	}

	public function getAPIClient()
	{
		return $this->Client;
	}

	public function setAPIClient(IClient $Client)
	{
		$this->Client = $Client;
	}

	public function getAPIEntityFields()
	{
		return $this->fields;
	}

	public function setAPIEntityFields(array $fields)
	{
		$this->fields = $fields;
	}

	public function getResourceUri()
	{
		if (empty($this->fields['resource_uri']))
		{
			$this->fields['resource_uri'] = $this->getAPIClient()->getAPIPathPrefix().$this->getApiEntityResource().'/'.$this->getId().'/';
		}
		return $this->fields['resource_uri'];
	}

	protected function getId()
	{
		return (isset($this->fields['id']) ? $this->fields['id'] : NULL);
	}

	/**
	 * @return Customer
	 */
	protected function getCustomer()
	{
		if (empty($this->Customer) && !empty($this->fields['customer']))
		{
			$data           = $this->getDataFromResourceURI($this->fields['customer']);
			$this->Customer = new Customer($this->getAPIClient(), $data);
		}
		return $this->Customer;
	}

	/**
	 * @return Reseller
	 */
	protected function getReseller()
	{
		if (empty($this->Reseller) && !empty($this->fields['reseller']))
		{
			$data           = $this->getDataFromResourceURI($this->fields['reseller']);
			$this->Reseller = new Reseller($this->getAPIClient(), $data);
		}
		return $this->Reseller;
	}

	protected function getDomain()
	{
		if (empty($this->Domain) && !empty($this->fields['domain']))
		{
			$data         = $this->getDataFromResourceURI($this->fields['domain']);
			$this->Domain = new Domain($this->getAPIClient(), $data);
		}
		return $this->Domain;
	}

	/**
	 * @return Admins[]
	 */
	protected function getAdmins()
	{
		if ($this->admins===NULL)
		{
			$this->admins = $this->getAPIClient()->API()->Admins()->get($this->getApiEntityResource().'/'.$this->getId());
		}
		return $this->admins;
	}

	protected function getEntityContacts(ActiveEntity $ContactEntity)
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
					$Contact = clone $ContactEntity;
					$Contact->setAPIEntityFields($contact_data);
					$this->contacts[] = $Contact;
				}
			}
		}
		return $this->contacts;
	}

	/**
	 * @return Brandinginfo
	 */
	protected function getBrandingInfo()
	{
		if (empty($this->BrandingInfo))
		{
			if (!empty($this->fields['branding_info']))
			{
				$data               = $this->getDataFromResourceURI($this->fields['branding_info']);
				$BrandingInfo       = new Brandinginfo($this->getAPIClient(), $data);
				$this->BrandingInfo = $BrandingInfo;
			}
		}
		return $this->BrandingInfo;
	}

	protected function getDataFromResourceURI($URI)
	{
		return $this->Client->callAPI(substr($URI, strlen($this->Client->getAPIPathPrefix())), 'GET');
	}

	public function parseCreateData(&$data)
	{

	}

	protected function massDelete(array $id_list)
	{
		return $this->Client->callAPI($this->getApiEntityResource().
				'/mass_delete/?id__in='.implode(',', $id_list), 'DELETE');
	}

	protected function getEmailAccount()
	{
		if (empty($this->EmailAccount) && !empty($this->fields['email_account']))
		{
			$data               = $this->getDataFromResourceURI($this->fields['email_account']);
			$this->EmailAccount = new EmailAccount($this->getAPIClient(), $data);
		}
		return $this->EmailAccount;
	}

	/**
	 * @param array $days_of_week
	 * @return array
	 * @throws \MailRoute\API\ValidationException
	 */
	protected function getValidatedDaysOfWeek(array $days_of_week)
	{
		if (empty($days_of_week))
		{
			throw new ValidationException("At least one day should be selected");
		}
		$week = array('sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat');
		$days = array('sun' => false, 'mon' => false, 'tue' => false, 'wed' => false, 'thu' => false, 'fri' => false, 'sat' => false);
		foreach ($days_of_week as $day)
		{
			$day = substr(strtolower($day), 0, 3);
			if (!in_array($day, $week))
			{
				continue;
			}
			$days[$day] = true;
		}
		if (!in_array(true, $days))
		{
			throw new ValidationException("At least one day should be selected");
		}
		return $days;
	}

	/**
	 * @param NotificationAccountTask|NotificationDomainTask $Notification
	 */
	protected function addNewNotification($Notification)
	{
		if ($Notification->getId())
		{
			if (!is_array($this->fields['notification_tasks']))
			{
				$this->fields['notification_tasks'] = array($this->fields['notification_tasks'], $Notification->getResourceUri());
			}
			else
			{
				$this->fields['notification_tasks'][] = $Notification->getResourceUri();
			}
			if (!empty($this->notification_tasks))
			{
				$this->notification_tasks[] = $Notification;
			}
		}
	}
}
