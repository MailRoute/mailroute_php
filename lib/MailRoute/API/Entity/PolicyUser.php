<?php
namespace MailRoute\API\Entity;

class PolicyUser extends Policy
{
	protected $api_entity_resource = 'policy_user';

	public function setUseDomainPolicy($use_domain_policy)
	{
		$this->fields['use_domain_policy'] = $use_domain_policy;
	}

	public function getUseDomainPolicy()
	{
		return $this->fields['use_domain_policy'];
	}

	public function getEmailAccount()
	{
		return parent::getEmailAccount();
	}
}
