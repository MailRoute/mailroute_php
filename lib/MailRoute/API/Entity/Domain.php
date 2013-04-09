<?php
namespace MailRoute\API\Entity;

use MailRoute\API\Exception;
use MailRoute\API\ValidationException;

class Domain extends \MailRoute\API\ActiveEntity
{
	protected $api_entity_resource = 'domain';
	protected $Customer;
	protected $domain_aliases;

	/**
	 * @param Customer $Customer
	 * @return bool
	 */
	public function moveToCustomer(Customer $Customer)
	{
		$this->setCustomer($Customer->getResourceUri());
		return $this->save();
	}

	/**
	 * @param string $email
	 * @return ContactDomain
	 */
	public function createContact($email)
	{
		$Contact = new ContactDomain($this->getAPIClient());
		$Contact->setDomain($this->getResourceUri());
		$Contact->setEmail($email);
		return $this->getAPIClient()->API()->ContactDomain()->create($Contact);
	}

	public function deleteContact($email)
	{
		/** @var ContactDomain[] $Contacts */
		$Contacts = $this->getAPIClient()->API()->ContactDomain()->
				filter(array('email' => $email, 'domain' => $this->getId()))->fetchList();
		if (empty($Contacts))
		{
			return true;
		}
		$deleted = 0;
		foreach ($Contacts as $Contact)
		{
			$deleted += $Contact->delete();
		}
		return $deleted;
	}

	/**
	 * @param string $server mailServer FQDN or IP address
	 * @param int $priority  mail server priority
	 * @return MailServer
	 */
	public function createMailServer($server, $priority = 10)
	{
		$MailServer = new MailServer($this->getAPIClient());
		$MailServer->setServer($server);
		$MailServer->setDomain($this->getResourceUri());
		$MailServer->setPriority($priority);
		return $this->getAPIClient()->API()->MailServer()->create($MailServer);
	}

	/**
	 * @param string $server mail server IP Address
	 * @return OutboundServer
	 */
	public function createOutboundServer($server)
	{
		$OutboundServer = new OutboundServer($this->getAPIClient());
		$OutboundServer->setServer($server);
		$OutboundServer->setDomain($this->getResourceUri());
		return $this->getAPIClient()->API()->OutboundServer()->create($OutboundServer);
	}

	/**
	 * @param string $localpart the localpart of the email address
	 * @param string $create_opt
	 * @param string $password
	 * @param bool $send_welcome
	 * @return EmailAccount
	 */
	public function createEmailAccount($localpart, $create_opt = 'generate_pwd', $password = '', $send_welcome = false)
	{
		$EmailAccount = new EmailAccount($this->getAPIClient());
		$EmailAccount->setLocalpart($localpart);
		$EmailAccount->setCreateOpt($create_opt);
		$EmailAccount->setPassword($password);
		$EmailAccount->setSendWelcome($send_welcome);
		$EmailAccount->setDomain($this->getResourceUri());
		return $this->getAPIClient()->API()->EmailAccount()->create($EmailAccount);
	}

	/**
	 * @param array $accounts each element of array can have keys as arguments to createEmailAccount method
	 * @return EmailAccount[] of results for each element (can contain exception object as value)
	 * @throws \MailRoute\API\ValidationException
	 */
	public function bulkCreateEmailAccount(array $accounts)
	{
		$results = array();
		foreach ($accounts as $account)
		{
			if (!isset($account['localpart']))
			{
				throw new ValidationException("localpart is required argument");
			}
			try
			{
				if (!isset($account['create_opt'])) $account['create_opt'] = 'generate_pwd';
				if (!isset($account['password'])) $account['password'] = '';
				if (!isset($account['send_welcome'])) $account['send_welcome'] = false;
				$results[] = $this->createEmailAccount($account['localpart'], $account['create_opt'], $account['password'], $account['send_welcome']);
			}
			catch (Exception $E)
			{
				$results[] = $E;
			}
		}
		return $results;
	}

	/**
	 * @param string $name
	 * @return DomainAlias
	 */
	public function createAlias($name)
	{
		$Alias = new DomainAlias($this->getAPIClient());
		$Alias->setDomain($this->getResourceUri());
		$Alias->setName($name);
		return $this->getAPIClient()->API()->DomainAlias()->create($Alias);
	}

	/**
	 * @param string $email
	 * @return Wblist
	 */
	public function addToBlackList($email)
	{
		$BlackList = new Wblist($this->getAPIClient());
		$BlackList->setEmail($email);
		$BlackList->setDomain($this->getResourceUri());
		$BlackList->setWb('b');
		return $this->getAPIClient()->API()->Wblist()->create($BlackList);
	}

	/**
	 * @param string $email
	 * @return Wblist
	 */
	public function addToWhiteList($email)
	{
		$WhiteList = new Wblist($this->getAPIClient());
		$WhiteList->setEmail($email);
		$WhiteList->setDomain($this->getResourceUri());
		$WhiteList->setWb('w');
		return $this->getAPIClient()->API()->Wblist()->create($WhiteList);
	}

	public function getActive()
	{
		return $this->fields['active'];
	}

	public function setActive($active)
	{
		$this->fields['active'] = $active;
	}

	public function getUserlistComplete()
	{
		return $this->fields['userlist_complete'];
	}

	public function setUserlistComplete($userlist_complete)
	{
		$this->fields['userlist_complete'] = $userlist_complete;
	}

	public function getContacts()
	{
		return $this->fields['contacts'];
	}

	public function getCreatedAt()
	{
		return $this->fields['created_at'];
	}

	/**
	 * @return Customer
	 */
	public function getCustomer()
	{
		if (empty($this->Customer))
		{
			$data           = $this->getDataFromResourceURI($this->fields['customer']);
			$this->Customer = new Customer($this->getAPIClient(), $data);
		}
		return $this->Customer;
	}

	public function setCustomer($Customer)
	{
		if (is_object($Customer))
		{
			$this->Customer = $Customer;
		}
		else
		{
			$this->fields['customer'] = $Customer;
		}
	}

	public function getDeliveryport()
	{
		return $this->fields['deliveryport'];
	}

	public function setDeliveryport($deliveryport)
	{
		$this->fields['deliveryport'] = $deliveryport;
	}

	/**
	 * @return DomainAlias[]
	 */
	public function getDomainAliases()
	{
		if (empty($this->domain_aliases))
		{
			$this->domain_aliases = $this->getAPIClient()->API()->DomainAlias()->filter(array('domain' => $this->getId()))->fetchList();
		}
		return $this->domain_aliases;
	}

	protected $email_accounts;

	/**
	 * @return EmailAccount[]
	 */
	public function getEmailAccounts()
	{
		if (empty($this->email_accounts))
		{
			$this->email_accounts = $this->getAPIClient()->API()->EmailAccount()->filter(array('domain' => $this->getId()))->fetchList();
		}
		return $this->email_accounts;
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

	protected $mail_servers;

	/**
	 * @return MailServer[]
	 */
	public function getMailServers()
	{
		if (empty($this->mail_servers))
		{
			$this->mail_servers = $this->getAPIClient()->API()->MailServer()->filter(array('domain' => $this->getId()))->fetchList();
		}
		return $this->mail_servers;
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

	public function getUpdatedAt()
	{
		return $this->fields['updated_at'];
	}

}
