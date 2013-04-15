<?php
namespace MailRoute\API\Entity;

class NotificationAccountTask extends \MailRoute\API\ActiveEntity
{
	protected $api_entity_resource = 'notification_account_task';
	protected $fields = array();

	public function getEmailAccount()
	{
		return parent::getEmailAccount();
	}

	public function setEmailAccount($email_account_uri)
	{
		$this->fields['email_account'] = $email_account_uri;
	}

	public function getEnabled()
	{
		return $this->fields['enabled'];
	}

	public function setEnabled($enabled)
	{
		$this->fields['enabled'] = $enabled;
	}

	public function getEnableDefault()
	{
		return $this->fields['enable_default'];
	}

	public function setEnableDefault($enable_default)
	{
		$this->fields['enable_default'] = $enable_default;
	}

	public function getId()
	{
		return $this->fields['id'];
	}

	public function getPriority()
	{
		return $this->fields['priority'];
	}

	public function setPriority($priority)
	{
		$this->fields['priority'] = $priority;
	}

	public function getDaysOfWeek()
	{
		$days = array('sun' => $this->fields['sun'],
					  'mon' => $this->fields['mon'],
					  'tue' => $this->fields['tue'],
					  'wed' => $this->fields['wed'],
					  'thu' => $this->fields['thu'],
					  'fri' => $this->fields['fri'],
					  'sat' => $this->fields['sat']);
		return array_keys($days, 1);
	}

	public function getHour()
	{
		return $this->fields['hour'];
	}

	public function getMinute()
	{
		return $this->fields['minute'];
	}

	public function getTimezone()
	{
		return $this->fields['timezone'];
	}
}
