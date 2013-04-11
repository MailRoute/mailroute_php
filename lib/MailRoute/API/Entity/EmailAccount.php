<?php
namespace MailRoute\API\Entity;

use MailRoute\API\ActiveEntity;
use MailRoute\API\NotFoundException;

class EmailAccount extends ActiveEntity
{
	protected $api_entity_resource = 'email_account';
	protected $fields = array();
	protected $PolicyUser;
	protected $Contact;
	protected $notification_tasks;
	protected $black_list;
	protected $white_list;
	protected $localpart_aliases;

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
		$result = $this->getAPIClient()->callAPI($this->getApiEntityResource().'/'.$this->getId().'/mass_add_aliases/', 'POST', array('aliases' => $localparts));
		return ($result!==false);
	}

	public function getId()
	{
		return $this->fields['id'];
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
		$Policy = $this->getPolicy();
		if (!$Policy->getUseDomainPolicy())
		{
			$Policy->setUseDomainPolicy(true);
			return $Policy->save();
		}
		return true;
	}

	/**
	 * @return PolicyUser
	 */
	public function getPolicy()
	{
		if (empty($this->PolicyUser) && !empty($this->fields['policy']))
		{
			$policy_data      = $this->getDataFromResourceURI($this->fields['policy']);
			$this->PolicyUser = new PolicyUser($this->getAPIClient(), $policy_data);
		}
		return $this->PolicyUser;
	}

	public function useSelfPolicy()
	{
		$Policy = $this->getPolicy();
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
		$AccountPolicy = $this->getPolicy();
		if (!$AccountPolicy->getUseDomainPolicy())
		{
			return $AccountPolicy;
		}
		else
		{
			$Domain       = $this->getDomain();
			$DomainPolicy = $Domain->getPolicy();
			return $DomainPolicy;
		}
	}

	public function getDomain()
	{
		return parent::getDomain();
	}

	public function useDomainNotifications()
	{
		if (empty($this->fields['use_domain_notifications']))
		{
			$this->fields['use_domain_notifications'] = 1;
			return $this->save();
		}
		return true;
	}

	public function useSelfNotifications()
	{
		if (!empty($this->fields['use_domain_notifications']))
		{
			$this->fields['use_domain_notifications'] = 0;
			return $this->save();
		}
		return true;
	}

	/**
	 * @return NotificationAccountTask[]|NotificationDomainTask[]
	 */
	public function getActiveNotificationTasks()
	{
		if ($this->fields['use_domain_notifications'])
		{
			$Domain             = $this->getDomain();
			$notification_tasks = $Domain->getNotificationTasks();
			return $notification_tasks;
		}
		else
		{
			return $this->getNotificationTasks();
		}
	}

	/**
	 * @return NotificationAccountTask[]
	 */
	public function getNotificationTasks()
	{
		if (empty($this->notification_tasks) && !empty($this->fields['notification_tasks']))
		{
			$data_list = $this->fields['notification_tasks'];
			foreach ($data_list as $data_uri)
			{
				$data                       = $this->getDataFromResourceURI($data_uri);
				$this->notification_tasks[] = new NotificationAccountTask($this->getAPIClient(), $data);
			}
		}
		return $this->notification_tasks;
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

	/**
	 * @return Wblist[]
	 */
	public function getBlackList()
	{
		if (empty($this->black_list))
		{
			$this->black_list = $this->getAPIClient()->API()->Wblist()->filter(array('wb' => 'b', 'email_account' => $this->getId()))->fetchList();
		}
		return $this->black_list;
	}

	/**
	 * @return Wblist[]
	 */
	public function getWhiteList()
	{
		if (empty($this->white_list))
		{
			$this->white_list = $this->getAPIClient()->API()->Wblist()->filter(array('wb' => 'w', 'email_account' => $this->getId()))->fetchList();
		}
		return $this->white_list;
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

	public function setDomain($domain)
	{
		$this->fields['domain'] = $domain;
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

	/**
	 * @return LocalpartAlias[]
	 */
	public function getLocalpartAliases()
	{
		if (empty($this->localpart_aliases))
		{
			$this->localpart_aliases = $this->getAPIClient()->API()->LocalpartAlias()->filter(array('email_account' => $this->getId()))->fetchList();
		}
		return $this->localpart_aliases;
	}

	public function setPassword($password)
	{
		$this->fields['password'] = $password;
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

	public function massDelete(array $id_list)
	{
		return parent::massDelete($id_list);
	}
}
