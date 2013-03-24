<?php
namespace MailRoute\API\Entity;

class PolicyDomain extends \MailRoute\API\ActiveEntity
{
	protected $api_entity_resource = 'policy_domain';
	protected $fields = array();

	public function getAddrExtensionBadHeader()
	{
		return $this->fields['addr_extension_bad_header'];
	}

	public function setAddrExtensionBadHeader($addr_extension_bad_header)
	{
		$this->fields['addr_extension_bad_header'] = $addr_extension_bad_header;
	}

	public function getAddrExtensionBanned()
	{
		return $this->fields['addr_extension_banned'];
	}

	public function setAddrExtensionBanned($addr_extension_banned)
	{
		$this->fields['addr_extension_banned'] = $addr_extension_banned;
	}

	public function getAddrExtensionSpam()
	{
		return $this->fields['addr_extension_spam'];
	}

	public function setAddrExtensionSpam($addr_extension_spam)
	{
		$this->fields['addr_extension_spam'] = $addr_extension_spam;
	}

	public function getAddrExtensionVirus()
	{
		return $this->fields['addr_extension_virus'];
	}

	public function setAddrExtensionVirus($addr_extension_virus)
	{
		$this->fields['addr_extension_virus'] = $addr_extension_virus;
	}

	public function getArchiveQuarantineTo()
	{
		return $this->fields['archive_quarantine_to'];
	}

	public function setArchiveQuarantineTo($archive_quarantine_to)
	{
		$this->fields['archive_quarantine_to'] = $archive_quarantine_to;
	}

	public function getBadHeaderLover()
	{
		return $this->fields['bad_header_lover'];
	}

	public function setBadHeaderLover($bad_header_lover)
	{
		$this->fields['bad_header_lover'] = $bad_header_lover;
	}

	public function getBadHeaderQuarantineTo()
	{
		return $this->fields['bad_header_quarantine_to'];
	}

	public function setBadHeaderQuarantineTo($bad_header_quarantine_to)
	{
		$this->fields['bad_header_quarantine_to'] = $bad_header_quarantine_to;
	}

	public function getBannedFilesLover()
	{
		return $this->fields['banned_files_lover'];
	}

	public function setBannedFilesLover($banned_files_lover)
	{
		$this->fields['banned_files_lover'] = $banned_files_lover;
	}

	public function getBannedQuarantineTo()
	{
		return $this->fields['banned_quarantine_to'];
	}

	public function setBannedQuarantineTo($banned_quarantine_to)
	{
		$this->fields['banned_quarantine_to'] = $banned_quarantine_to;
	}

	public function getBypassBannedChecks()
	{
		return $this->fields['bypass_banned_checks'];
	}

	public function setBypassBannedChecks($bypass_banned_checks)
	{
		$this->fields['bypass_banned_checks'] = $bypass_banned_checks;
	}

	public function getBypassHeaderChecks()
	{
		return $this->fields['bypass_header_checks'];
	}

	public function setBypassHeaderChecks($bypass_header_checks)
	{
		$this->fields['bypass_header_checks'] = $bypass_header_checks;
	}

	public function getBypassSpamChecks()
	{
		return $this->fields['bypass_spam_checks'];
	}

	public function setBypassSpamChecks($bypass_spam_checks)
	{
		$this->fields['bypass_spam_checks'] = $bypass_spam_checks;
	}

	public function getBypassVirusChecks()
	{
		return $this->fields['bypass_virus_checks'];
	}

	public function setBypassVirusChecks($bypass_virus_checks)
	{
		$this->fields['bypass_virus_checks'] = $bypass_virus_checks;
	}

	public function getDomain()
	{
		return $this->fields['domain'];
	}

	public function getId()
	{
		return $this->fields['id'];
	}

	public function setId($id)
	{
		$this->fields['id'] = $id;
	}

	public function getMessageSizeLimit()
	{
		return $this->fields['message_size_limit'];
	}

	public function setMessageSizeLimit($message_size_limit)
	{
		$this->fields['message_size_limit'] = $message_size_limit;
	}

	public function getPriority()
	{
		return $this->fields['priority'];
	}

	public function setPriority($priority)
	{
		$this->fields['priority'] = $priority;
	}

	public function getResourceUri()
	{
		return $this->fields['resource_uri'];
	}

	public function getSpamKillLevel()
	{
		return $this->fields['spam_kill_level'];
	}

	public function setSpamKillLevel($spam_kill_level)
	{
		$this->fields['spam_kill_level'] = $spam_kill_level;
	}

	public function getSpamLover()
	{
		return $this->fields['spam_lover'];
	}

	public function setSpamLover($spam_lover)
	{
		$this->fields['spam_lover'] = $spam_lover;
	}

	public function getSpamQuarantineCutoffLevel()
	{
		return $this->fields['spam_quarantine_cutoff_level'];
	}

	public function setSpamQuarantineCutoffLevel($spam_quarantine_cutoff_level)
	{
		$this->fields['spam_quarantine_cutoff_level'] = $spam_quarantine_cutoff_level;
	}

	public function getSpamQuarantineTo()
	{
		return $this->fields['spam_quarantine_to'];
	}

	public function setSpamQuarantineTo($spam_quarantine_to)
	{
		$this->fields['spam_quarantine_to'] = $spam_quarantine_to;
	}

	public function getSpamSubjectTag()
	{
		return $this->fields['spam_subject_tag'];
	}

	public function setSpamSubjectTag($spam_subject_tag)
	{
		$this->fields['spam_subject_tag'] = $spam_subject_tag;
	}

	public function getSpamSubjectTag2()
	{
		return $this->fields['spam_subject_tag2'];
	}

	public function setSpamSubjectTag2($spam_subject_tag2)
	{
		$this->fields['spam_subject_tag2'] = $spam_subject_tag2;
	}

	public function getSpamSubjectTag3()
	{
		return $this->fields['spam_subject_tag3'];
	}

	public function setSpamSubjectTag3($spam_subject_tag3)
	{
		$this->fields['spam_subject_tag3'] = $spam_subject_tag3;
	}

	public function getSpamTag2Level()
	{
		return $this->fields['spam_tag2_level'];
	}

	public function setSpamTag2Level($spam_tag2_level)
	{
		$this->fields['spam_tag2_level'] = $spam_tag2_level;
	}

	public function getSpamTag3Level()
	{
		return $this->fields['spam_tag3_level'];
	}

	public function setSpamTag3Level($spam_tag3_level)
	{
		$this->fields['spam_tag3_level'] = $spam_tag3_level;
	}

	public function getSpamTagLevel()
	{
		return $this->fields['spam_tag_level'];
	}

	public function setSpamTagLevel($spam_tag_level)
	{
		$this->fields['spam_tag_level'] = $spam_tag_level;
	}

	public function getUncheckedLover()
	{
		return $this->fields['unchecked_lover'];
	}

	public function setUncheckedLover($unchecked_lover)
	{
		$this->fields['unchecked_lover'] = $unchecked_lover;
	}

	public function getUncheckedQuarantineTo()
	{
		return $this->fields['unchecked_quarantine_to'];
	}

	public function setUncheckedQuarantineTo($unchecked_quarantine_to)
	{
		$this->fields['unchecked_quarantine_to'] = $unchecked_quarantine_to;
	}

	public function getVirusLover()
	{
		return $this->fields['virus_lover'];
	}

	public function setVirusLover($virus_lover)
	{
		$this->fields['virus_lover'] = $virus_lover;
	}

	public function getVirusQuarantineTo()
	{
		return $this->fields['virus_quarantine_to'];
	}

	public function setVirusQuarantineTo($virus_quarantine_to)
	{
		$this->fields['virus_quarantine_to'] = $virus_quarantine_to;
	}

	public function getWarnbadhrecip()
	{
		return $this->fields['warnbadhrecip'];
	}

	public function setWarnbadhrecip($warnbadhrecip)
	{
		$this->fields['warnbadhrecip'] = $warnbadhrecip;
	}

	public function getWarnbannedrecip()
	{
		return $this->fields['warnbannedrecip'];
	}

	public function setWarnbannedrecip($warnbannedrecip)
	{
		$this->fields['warnbannedrecip'] = $warnbannedrecip;
	}

	public function getWarnvirusrecip()
	{
		return $this->fields['warnvirusrecip'];
	}

	public function setWarnvirusrecip($warnvirusrecip)
	{
		$this->fields['warnvirusrecip'] = $warnvirusrecip;
	}

}
