<?php
namespace MailRoute\API\Entity;

class Customer extends \MailRoute\API\ActiveEntity
{
	protected $api_entity_resource = 'customer';
	protected $fields = array();

	/**
	 * @param Domain|array $Domain
	 * @return Domain
	 */
	public function createDomain($Domain)
	{
		if (is_object($Domain))
		{
			$Domain->setCustomer($this->getResourceUri());
		}
		else
		{
			$Domain['customer'] = $this->getResourceUri();
		}
		return $this->getAPIClient()->API()->Domain()->create($Domain);
	}

	public function getAllowBranding()
	{
		return $this->fields['allow_branding'];
	}

	public function setAllowBranding($allow_branding)
	{
		$this->fields['allow_branding'] = $allow_branding;
	}

	public function getBrandingInfo()
	{
		return $this->fields['branding_info'];
	}

	public function getContacts()
	{
		return $this->fields['contacts'];
	}

	public function getCreatedAt()
	{
		return $this->fields['created_at'];
	}

	public function getDomains()
	{
		return $this->fields['domains'];
	}

	public function getId()
	{
		return $this->fields['id'];
	}

	public function setId($id)
	{
		$this->fields['id'] = $id;
	}

	public function getIsFullUserList()
	{
		return $this->fields['is_full_user_list'];
	}

	public function setIsFullUserList($is_full_user_list)
	{
		$this->fields['is_full_user_list'] = $is_full_user_list;
	}

	public function getName()
	{
		return $this->fields['name'];
	}

	public function setName($name)
	{
		$this->fields['name'] = $name;
	}

	public function getReportedUserCount()
	{
		return $this->fields['reported_user_count'];
	}

	public function setReportedUserCount($reported_user_count)
	{
		$this->fields['reported_user_count'] = $reported_user_count;
	}

	public function getReseller()
	{
		return $this->fields['reseller'];
	}

	public function setReseller($reseller)
	{
		$this->fields['reseller'] = $reseller;
	}

	public function getUpdatedAt()
	{
		return $this->fields['updated_at'];
	}

}
