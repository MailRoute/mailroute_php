<?php
namespace MailRoute\API\Entity;

/**
* @method save()
* @method delete()
*/
class Customer
{
	private $allow_branding;
	private $branding_info;
	private $contacts;
	private $created_at;
	private $domains;
	private $id;
	private $is_full_user_list;
	private $name;
	private $reported_user_count;
	private $reseller;
	private $resource_uri;
	private $updated_at;

	public function getAllowBranding()
	{
		return $this->allow_branding;
	}

	public function setAllowBranding($allow_branding)
	{
		$this->allow_branding = $allow_branding;
	}

	public function getBrandingInfo()
	{
		return $this->branding_info;
	}

	public function getContacts()
	{
		return $this->contacts;
	}

	public function getCreatedAt()
	{
		return $this->created_at;
	}

	public function getDomains()
	{
		return $this->domains;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getIsFullUserList()
	{
		return $this->is_full_user_list;
	}

	public function setIsFullUserList($is_full_user_list)
	{
		$this->is_full_user_list = $is_full_user_list;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function getReportedUserCount()
	{
		return $this->reported_user_count;
	}

	public function setReportedUserCount($reported_user_count)
	{
		$this->reported_user_count = $reported_user_count;
	}

	public function getReseller()
	{
		return $this->reseller;
	}

	public function setReseller($reseller)
	{
		$this->reseller = $reseller;
	}

	public function getResourceUri()
	{
		return $this->resource_uri;
	}

	public function getUpdatedAt()
	{
		return $this->updated_at;
	}

}
