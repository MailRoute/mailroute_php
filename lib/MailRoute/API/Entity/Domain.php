<?php
namespace MailRoute\API\Entity;

class Domain extends \MailRoute\API\ActiveEntity
{
	protected $api_entity_resource = 'domain';
	protected $fields = array();

	public function getActive()
	{
		return $this->fields['active'];
	}

	public function setActive($active)
	{
		$this->fields['active'] = $active;
	}

	public function getBounceUnlisted()
	{
		return $this->fields['bounce_unlisted'];
	}

	public function setBounceUnlisted($bounce_unlisted)
	{
		$this->fields['bounce_unlisted'] = $bounce_unlisted;
	}

	public function getContacts()
	{
		return $this->fields['contacts'];
	}

	public function getCreatedAt()
	{
		return $this->fields['created_at'];
	}

	public function getCustomer()
	{
		return $this->fields['customer'];
	}

	public function setCustomer($customer)
	{
		$this->fields['customer'] = $customer;
	}

	public function getDeliveryport()
	{
		return $this->fields['deliveryport'];
	}

	public function setDeliveryport($deliveryport)
	{
		$this->fields['deliveryport'] = $deliveryport;
	}

	public function getDomainAliases()
	{
		return $this->fields['domain_aliases'];
	}

	public function getEmailAccounts()
	{
		return $this->fields['email_accounts'];
	}

	public function getHoldEmail()
	{
		return $this->fields['hold_email'];
	}

	public function setHoldEmail($hold_email)
	{
		$this->fields['hold_email'] = $hold_email;
	}

	public function getId()
	{
		return $this->fields['id'];
	}

	public function setId($id)
	{
		$this->fields['id'] = $id;
	}

	public function getMailServers()
	{
		return $this->fields['mail_servers'];
	}

	public function getName()
	{
		return $this->fields['name'];
	}

	public function setName($name)
	{
		$this->fields['name'] = $name;
	}

	public function getNotificationTask()
	{
		return $this->fields['notification_task'];
	}

	public function getOutboundEnabled()
	{
		return $this->fields['outbound_enabled'];
	}

	public function setOutboundEnabled($outbound_enabled)
	{
		$this->fields['outbound_enabled'] = $outbound_enabled;
	}

	public function getOutboundServers()
	{
		return $this->fields['outbound_servers'];
	}

	public function getPolicy()
	{
		return $this->fields['policy'];
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
