<?php
namespace MailRoute\API\Entity;

class LocalpartAlias extends \MailRoute\API\ActiveEntity
{
	protected $api_entity_resource = 'localpart_alias';
	protected $fields = array();

	public function getCreatedAt()
	{
		return $this->fields['created_at'];
	}

	public function getDomain()
	{
		return $this->fields['domain'];
	}

	public function getEmailAccount()
	{
		return parent::getEmailAccount();
	}

	public function setEmailAccount($email_account)
	{
		$this->fields['email_account'] = $email_account;
	}

	public function getId()
	{
		return $this->fields['id'];
	}

	public function setId($id)
	{
		$this->fields['id'] = $id;
	}

	public function getLocalpart()
	{
		return $this->fields['localpart'];
	}

	public function setLocalpart($localpart)
	{
		$this->fields['localpart'] = $localpart;
	}

	public function getType()
	{
		return $this->fields['type'];
	}

	public function setType($type)
	{
		$this->fields['type'] = $type;
	}

	public function getUpdatedAt()
	{
		return $this->fields['updated_at'];
	}

}
