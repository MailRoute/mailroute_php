<?php
namespace MailRoute\API\Entity;

class Mailaddr extends \MailRoute\API\ActiveEntity
{
	protected $api_entity_resource = 'mailaddr';
	protected $fields = array();

	public function getEmail()
	{
		return $this->fields['email'];
	}

	public function setEmail($email)
	{
		$this->fields['email'] = $email;
	}

	public function getId()
	{
		return $this->fields['id'];
	}

	public function getResourceUri()
	{
		return $this->fields['resource_uri'];
	}

}
