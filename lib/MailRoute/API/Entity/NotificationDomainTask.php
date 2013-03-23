<?php
namespace MailRoute\API\Entity;

class NotificationDomainTask
{
	private $domain;
	private $enabled;
	private $id;
	private $priority;
	private $resource_uri;

	public function getDomain()
	{
		return $this->domain;
	}

	public function getEnabled()
	{
		return $this->enabled;
	}

	public function setEnabled($enabled)
	{
		$this->enabled = $enabled;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getPriority()
	{
		return $this->priority;
	}

	public function setPriority($priority)
	{
		$this->priority = $priority;
	}

	public function getResourceUri()
	{
		return $this->resource_uri;
	}

}
