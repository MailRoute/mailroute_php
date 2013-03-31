<?php
namespace MailRoute\API\Entity;

use MailRoute\API\Exception;

class EmailAccount extends \MailRoute\API\ActiveEntity
{
	protected $api_entity_resource = 'email_account';
	protected $fields = array();

	/**
	 * @param $localpart
	 * @return LocalpartAlias
	 */
	public function addAlias($localpart)
	{
		$Alias = new LocalpartAlias($this->getAPIClient());
		$Alias->setEmailAccount($this->getResourceUri());
		$Alias->setLocalpart($localpart);
		return $this->getAPIClient()->API()->LocalpartAlias()->create($Alias);
	}

	/**
	 * @param array $localparts
	 * @return LocalpartAlias[]
	 */
	public function bulkAddAlias(array $localparts)
	{
		$results = array();
		foreach ($localparts as $localpart)
		{
			try
			{
				$results[] = $this->addAlias($localpart);
			}
			catch (Exception $E)
			{
				$results[] = $E;
			}
		}
		return $results;
	}

	/**
	 * @param $email
	 * @return Wblist
	 */
	public function addToBlackList($email)
	{
		$WBList = new Wblist($this->getAPIClient());
		$WBList->setEmailAccount($this->getResourceUri());
		$WBList->setEmail($email);
		$WBList->setWb('b');
		return $this->getAPIClient()->API()->Wblist()->create($WBList);
	}

	/**
	 * @param $email
	 * @return Wblist
	 */
	public function addToWhiteList($email)
	{
		$WBList = new Wblist($this->getAPIClient());
		$WBList->setEmailAccount($this->getResourceUri());
		$WBList->setEmail($email);
		$WBList->setWb('w');
		return $this->getAPIClient()->API()->Wblist()->create($WBList);
	}

	/**
	 * @param EmailAccount[] $EmailAccounts
	 * @return bool
	 */
	public function makeAliasesFrom(array $EmailAccounts)
	{
		$data = array();
		foreach ($EmailAccounts as $EmailAccount)
		{
			$data[] = $EmailAccount->getResourceUri();
		}
		$result = $this->getAPIClient()->callAPI($this->getApiEntityResource().'/'.$this->getId().'/users_to_alias/', 'POST', $data);
		return ($result!==false);
	}

	public function getChangePwd()
	{
		return $this->fields['change_pwd'];
	}

	public function setChangePwd($change_pwd)
	{
		$this->fields['change_pwd'] = $change_pwd;
	}

	public function getConfirmPassword()
	{
		return $this->fields['confirm_password'];
	}

	public function setConfirmPassword($confirm_password)
	{
		$this->fields['confirm_password'] = $confirm_password;
	}

	public function getContact()
	{
		return $this->fields['contact'];
	}

	public function getCreateOpt()
	{
		return $this->fields['create_opt'];
	}

	public function setCreateOpt($create_opt)
	{
		$this->fields['create_opt'] = $create_opt;
	}

	public function getCreatedAt()
	{
		return $this->fields['created_at'];
	}

	public function getDomain()
	{
		return $this->fields['domain'];
	}

	public function setDomain($domain)
	{
		$this->fields['domain'] = $domain;
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

	public function getLocalpartAliases()
	{
		return $this->fields['localpart_aliases'];
	}

	public function getNotificationTask()
	{
		return $this->fields['notification_task'];
	}

	public function setPassword($password)
	{
		$this->fields['password'] = $password;
	}

	public function getPolicy()
	{
		return $this->fields['policy'];
	}

	public function getPriority()
	{
		return $this->fields['priority'];
	}

	public function setPriority($priority)
	{
		$this->fields['priority'] = $priority;
	}

	public function getSendWelcome()
	{
		return $this->fields['send_welcome'];
	}

	public function setSendWelcome($send_welcome)
	{
		$this->fields['send_welcome'] = $send_welcome;
	}

	public function getUpdatedAt()
	{
		return $this->fields['updated_at'];
	}

}
