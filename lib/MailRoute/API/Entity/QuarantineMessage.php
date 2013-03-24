<?php
namespace MailRoute\API\Entity;

class QuarantineMessage extends \MailRoute\API\ActiveEntity
{
	protected $api_entity_resource = 'quarantine_message';
	protected $fields = array('resource_uri');

	public function getResourceUri()
	{
		return $this->fields['resource_uri'];
	}

}
