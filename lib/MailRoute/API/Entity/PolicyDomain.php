<?php
namespace MailRoute\API\Entity;

class PolicyDomain extends Policy
{
	protected $api_entity_resource = 'policy_domain';

	public function getDomain()
	{
		return parent::getDomain();
	}

}
