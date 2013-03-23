<?php
namespace MailRoute\API\Entity;

class Domain
{
	private $active;
	private $bounce_unlisted;
	private $contacts;
	private $created_at;
	private $customer;
	private $deliveryport;
	private $domain_aliases;
	private $email_accounts;
	private $hold_email;
	private $id;
	private $mail_servers;
	private $name;
	private $notification_task;
	private $outbound_enabled;
	private $outbound_servers;
	private $policy;
	private $resource_uri;
	private $updated_at;

	public function getActive()
	{
		return $this->active;
	}

	public function setActive($active)
	{
		$this->active = $active;
	}

	public function getBounceUnlisted()
	{
		return $this->bounce_unlisted;
	}

	public function setBounceUnlisted($bounce_unlisted)
	{
		$this->bounce_unlisted = $bounce_unlisted;
	}

	public function getContacts()
	{
		return $this->contacts;
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

	public function getDeliveryport()
	{
		return $this->deliveryport;
	}

	public function setDeliveryport($deliveryport)
	{
		$this->deliveryport = $deliveryport;
	}

	public function getDomainAliases()
	{
		return $this->domain_aliases;
	}

	public function getEmailAccounts()
	{
		return $this->email_accounts;
	}

	public function getHoldEmail()
	{
		return $this->hold_email;
	}

	public function setHoldEmail($hold_email)
	{
		$this->hold_email = $hold_email;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getMailServers()
	{
		return $this->mail_servers;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function getNotificationTask()
	{
		return $this->notification_task;
	}

	public function getOutboundEnabled()
	{
		return $this->outbound_enabled;
	}

	public function setOutboundEnabled($outbound_enabled)
	{
		$this->outbound_enabled = $outbound_enabled;
	}

	public function getOutboundServers()
	{
		return $this->outbound_servers;
	}

	public function getPolicy()
	{
		return $this->policy;
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
