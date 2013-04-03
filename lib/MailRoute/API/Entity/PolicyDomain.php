<?php
namespace MailRoute\API\Entity;

class PolicyDomain extends Policy
{
	protected $api_entity_resource = 'policy_domain';

	public function getDefaultPolicy()
	{
		return $this->getAPIClient()->API()->PolicyDomain()->get('default_policy');
	}

	public function getDomain()
	{
		return $this->fields['domain'];
	}

}
