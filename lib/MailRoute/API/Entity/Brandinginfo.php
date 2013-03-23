<?php
namespace MailRoute\API\Entity;

class Brandinginfo
{
	private $color;
	private $created_at;
	private $customer;
	private $domain;
	private $email_from;
	private $enabled;
	private $favicon;
	private $highlight_color;
	private $id;
	private $logo;
	private $reseller;
	private $resource_uri;
	private $service_name;
	private $ssl_cert_passphrase;
	private $subdomain;
	private $updated_at;

	public function getColor()
	{
		return $this->color;
	}

	public function setColor($color)
	{
		$this->color = $color;
	}

	public function getCreatedAt()
	{
		return $this->created_at;
	}

	public function getCustomer()
	{
		return $this->customer;
	}

	public function getDomain()
	{
		return $this->domain;
	}

	public function setDomain($domain)
	{
		$this->domain = $domain;
	}

	public function getEmailFrom()
	{
		return $this->email_from;
	}

	public function setEmailFrom($email_from)
	{
		$this->email_from = $email_from;
	}

	public function getEnabled()
	{
		return $this->enabled;
	}

	public function setEnabled($enabled)
	{
		$this->enabled = $enabled;
	}

	public function getFavicon()
	{
		return $this->favicon;
	}

	public function setFavicon($favicon)
	{
		$this->favicon = $favicon;
	}

	public function getHighlightColor()
	{
		return $this->highlight_color;
	}

	public function setHighlightColor($highlight_color)
	{
		$this->highlight_color = $highlight_color;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getLogo()
	{
		return $this->logo;
	}

	public function setLogo($logo)
	{
		$this->logo = $logo;
	}

	public function getReseller()
	{
		return $this->reseller;
	}

	public function getResourceUri()
	{
		return $this->resource_uri;
	}

	public function getServiceName()
	{
		return $this->service_name;
	}

	public function setServiceName($service_name)
	{
		$this->service_name = $service_name;
	}

	public function getSslCertPassphrase()
	{
		return $this->ssl_cert_passphrase;
	}

	public function setSslCertPassphrase($ssl_cert_passphrase)
	{
		$this->ssl_cert_passphrase = $ssl_cert_passphrase;
	}

	public function getSubdomain()
	{
		return $this->subdomain;
	}

	public function setSubdomain($subdomain)
	{
		$this->subdomain = $subdomain;
	}

	public function getUpdatedAt()
	{
		return $this->updated_at;
	}

}
