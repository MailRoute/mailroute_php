<?php
namespace MailRoute\API\Entity;

class Brandinginfo extends \MailRoute\API\ActiveEntity
{
	protected $api_entity_resource = 'brandinginfo';
	protected $fields = array();

	public function getColor()
	{
		return $this->fields['color'];
	}

	public function setColor($color)
	{
		$this->fields['color'] = $color;
	}

	public function getCreatedAt()
	{
		return $this->fields['created_at'];
	}

	public function getCustomer()
	{
		return $this->fields['customer'];
	}

	public function getDomain()
	{
		return $this->fields['domain'];
	}

	public function setDomain($domain)
	{
		$this->fields['domain'] = $domain;
	}

	public function getEmailFrom()
	{
		return $this->fields['email_from'];
	}

	public function setEmailFrom($email_from)
	{
		$this->fields['email_from'] = $email_from;
	}

	public function getEnabled()
	{
		return $this->fields['enabled'];
	}

	public function setEnabled($enabled)
	{
		$this->fields['enabled'] = $enabled;
	}

	public function getFavicon()
	{
		return $this->fields['favicon'];
	}

	public function setFavicon($favicon)
	{
		$this->fields['favicon'] = $favicon;
	}

	public function getHighlightColor()
	{
		return $this->fields['highlight_color'];
	}

	public function setHighlightColor($highlight_color)
	{
		$this->fields['highlight_color'] = $highlight_color;
	}

	public function getId()
	{
		return $this->fields['id'];
	}

	public function setId($id)
	{
		$this->fields['id'] = $id;
	}

	public function getLogo()
	{
		return $this->fields['logo'];
	}

	public function setLogo($logo)
	{
		$this->fields['logo'] = $logo;
	}

	public function getReseller()
	{
		return $this->fields['reseller'];
	}

	public function getServiceName()
	{
		return $this->fields['service_name'];
	}

	public function setServiceName($service_name)
	{
		$this->fields['service_name'] = $service_name;
	}

	public function getSslCertPassphrase()
	{
		return $this->fields['ssl_cert_passphrase'];
	}

	public function setSslCertPassphrase($ssl_cert_passphrase)
	{
		$this->fields['ssl_cert_passphrase'] = $ssl_cert_passphrase;
	}

	public function getSubdomain()
	{
		return $this->fields['subdomain'];
	}

	public function setSubdomain($subdomain)
	{
		$this->fields['subdomain'] = $subdomain;
	}

	public function getUpdatedAt()
	{
		return $this->fields['updated_at'];
	}

}
