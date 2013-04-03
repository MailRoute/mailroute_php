<?php
namespace MailRoute\API\Entity;

use MailRoute\API\NotFoundException;

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
	 * @return boolean
	 */
	public function bulkAddAlias(array $localparts)
	{
		$result = $this->getAPIClient()->callAPI($this->getApiEntityResource().'/'.$this->getId().'/mass_add_aliases/', 'POST', $localparts);
		return ($result!==false);
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

	public function useDomainPolicy()
	{
		$Policy = $this->getAccountPolicy();
		if (!$Policy->getUseDomainPolicy())
		{
			$Policy->setUseDomainPolicy(true);
			return $Policy->save();
		}
		return true;
	}

	public function useSelfPolicy()
	{
		$Policy = $this->getAccountPolicy();
		if ($Policy->getUseDomainPolicy())
		{
			$Policy->setUseDomainPolicy(false);
			return $Policy->save();
		}
		return true;
	}

	public function regenerateApiKey()
	{
		return $this->getAPIClient()->callAPI($this->getApiEntityResource().'/'.$this->getId().'/regenerate_api_key', 'POST');
	}

	/**
	 * @return PolicyDomain|PolicyUser
	 */
	public function getActivePolicy()
	{
		$AccountPolicy = $this->getAccountPolicy();
		if (!$AccountPolicy->getUseDomainPolicy())
		{
			return $AccountPolicy;
		}
		else
		{
			$Client       = $this->getAPIClient();
			$domain_data  = $this->getDataFromResourceURI($this->getDomain());
			$Domain       = new Domain($Client, $domain_data);
			$policy_data  = $this->getDataFromResourceURI($Domain->getPolicy());
			$DomainPolicy = new PolicyDomain($Client, $policy_data);
			return $DomainPolicy;
		}
	}

	public function useDomainNotification()
	{
		$NotificationTask = $this->getNotificationAccountTaskObject();
		if (!$NotificationTask->getEnableDefault())
		{
			$NotificationTask->setEnableDefault(1);
			return $NotificationTask->save();
		}
		return true;
	}

	public function useSelfNotification()
	{
		$NotificationTask = $this->getNotificationAccountTaskObject();
		if ($NotificationTask->getEnableDefault())
		{
			$NotificationTask->setEnableDefault(0);
			return $NotificationTask->save();
		}
		return true;
	}

	/**
	 * @return NotificationAccountTask|NotificationDomainTask
	 */
	public function getActiveNotification()
	{
		$NotificationTask = $this->getNotificationAccountTaskObject();
		if ($NotificationTask->getEnableDefault())
		{
			$Client            = $this->getAPIClient();
			$domain_data       = $this->getDataFromResourceURI($this->getDomain());
			$Domain            = new Domain($Client, $domain_data);
			$notification_data = $this->getDataFromResourceURI($Domain->getNotificationTask());
			$NotificationTask  = new NotificationDomainTask($Client, $notification_data);
			return $NotificationTask;
		}
		else
		{
			return $NotificationTask;
		}
	}

	public function parseCreateData(&$data)
	{
		if (!isset($data['create_opt']))
		{
			$data['create_opt'] = 'generate_pwd';
		}
		if (isset($data['email']) && strpos($data['email'], '@')!==false)
		{
			list($localpart, $domain) = explode('@', $data['email']);
			if (!empty($localpart))
			{
				$data['localpart'] = $localpart;
			}
			if (!empty($domain) && empty($data['domain']))
			{
				/** @var Domain[] $Domains */
				$Domains = $this->getAPIClient()->API()->Domain()->filter(array('name' => $domain))->limit(1)->fetchList();
				if (!empty($Domains))
				{
					$DomainEntity   = $Domains[0];
					$data['domain'] = $DomainEntity->getResourceUri();
				}
				else
				{
					throw new NotFoundException('Domain '.$domain.' was not found', 404);
				}
			}
		}
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

	/**
	 * @return PolicyUser
	 */
	protected function getAccountPolicy()
	{
		$Client      = $this->getAPIClient();
		$policy_data = $this->getDataFromResourceURI($this->getPolicy());
		$Policy      = new PolicyUser($Client, $policy_data);
		return $Policy;
	}

	/**
	 * @return NotificationAccountTask
	 */
	protected function getNotificationAccountTaskObject()
	{
		$notification_data = $this->getDataFromResourceURI($this->getNotificationTask());
		$NotificationTask  = new NotificationAccountTask($this->getAPIClient(), $notification_data);
		return $NotificationTask;
	}

	public function massDelete(array $id_list)
	{
		return parent::massDelete($id_list);
	}
}
