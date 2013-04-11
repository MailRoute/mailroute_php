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

}
