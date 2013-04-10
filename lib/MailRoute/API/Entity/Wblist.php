<?php
namespace MailRoute\API\Entity;

class Wblist extends \MailRoute\API\ActiveEntity
{
	protected $api_entity_resource = 'wblist';
	protected $fields = array();

	public function getDomain()
	{
		return parent::getDomain();
	}

	public function setDomain($domain)
	{
		$this->fields['domain'] = $domain;
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

	public function getWb()
	{
		return $this->fields['wb'];
	}

	public function setWb($wb)
	{
		$this->fields['wb'] = $wb;
	}

	public function getEmail()
	{
		return $this->fields['email'];
	}

	public function setEmail($email)
	{
		$this->fields['email'] = $email;
	}

	public function massDelete(array $id_list)
	{
		return parent::massDelete($id_list);
	}
}
