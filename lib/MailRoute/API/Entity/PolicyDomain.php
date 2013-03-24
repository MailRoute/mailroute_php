<?php
namespace MailRoute\API\Entity;

/**
* @method save()
* @method delete()
*/
class PolicyDomain
{
	private $addr_extension_bad_header;
	private $addr_extension_banned;
	private $addr_extension_spam;
	private $addr_extension_virus;
	private $archive_quarantine_to;
	private $bad_header_lover;
	private $bad_header_quarantine_to;
	private $banned_files_lover;
	private $banned_quarantine_to;
	private $bypass_banned_checks;
	private $bypass_header_checks;
	private $bypass_spam_checks;
	private $bypass_virus_checks;
	private $domain;
	private $id;
	private $message_size_limit;
	private $priority;
	private $resource_uri;
	private $spam_kill_level;
	private $spam_lover;
	private $spam_quarantine_cutoff_level;
	private $spam_quarantine_to;
	private $spam_subject_tag;
	private $spam_subject_tag2;
	private $spam_subject_tag3;
	private $spam_tag2_level;
	private $spam_tag3_level;
	private $spam_tag_level;
	private $unchecked_lover;
	private $unchecked_quarantine_to;
	private $virus_lover;
	private $virus_quarantine_to;
	private $warnbadhrecip;
	private $warnbannedrecip;
	private $warnvirusrecip;

	public function getAddrExtensionBadHeader()
	{
		return $this->addr_extension_bad_header;
	}

	public function setAddrExtensionBadHeader($addr_extension_bad_header)
	{
		$this->addr_extension_bad_header = $addr_extension_bad_header;
	}

	public function getAddrExtensionBanned()
	{
		return $this->addr_extension_banned;
	}

	public function setAddrExtensionBanned($addr_extension_banned)
	{
		$this->addr_extension_banned = $addr_extension_banned;
	}

	public function getAddrExtensionSpam()
	{
		return $this->addr_extension_spam;
	}

	public function setAddrExtensionSpam($addr_extension_spam)
	{
		$this->addr_extension_spam = $addr_extension_spam;
	}

	public function getAddrExtensionVirus()
	{
		return $this->addr_extension_virus;
	}

	public function setAddrExtensionVirus($addr_extension_virus)
	{
		$this->addr_extension_virus = $addr_extension_virus;
	}

	public function getArchiveQuarantineTo()
	{
		return $this->archive_quarantine_to;
	}

	public function setArchiveQuarantineTo($archive_quarantine_to)
	{
		$this->archive_quarantine_to = $archive_quarantine_to;
	}

	public function getBadHeaderLover()
	{
		return $this->bad_header_lover;
	}

	public function setBadHeaderLover($bad_header_lover)
	{
		$this->bad_header_lover = $bad_header_lover;
	}

	public function getBadHeaderQuarantineTo()
	{
		return $this->bad_header_quarantine_to;
	}

	public function setBadHeaderQuarantineTo($bad_header_quarantine_to)
	{
		$this->bad_header_quarantine_to = $bad_header_quarantine_to;
	}

	public function getBannedFilesLover()
	{
		return $this->banned_files_lover;
	}

	public function setBannedFilesLover($banned_files_lover)
	{
		$this->banned_files_lover = $banned_files_lover;
	}

	public function getBannedQuarantineTo()
	{
		return $this->banned_quarantine_to;
	}

	public function setBannedQuarantineTo($banned_quarantine_to)
	{
		$this->banned_quarantine_to = $banned_quarantine_to;
	}

	public function getBypassBannedChecks()
	{
		return $this->bypass_banned_checks;
	}

	public function setBypassBannedChecks($bypass_banned_checks)
	{
		$this->bypass_banned_checks = $bypass_banned_checks;
	}

	public function getBypassHeaderChecks()
	{
		return $this->bypass_header_checks;
	}

	public function setBypassHeaderChecks($bypass_header_checks)
	{
		$this->bypass_header_checks = $bypass_header_checks;
	}

	public function getBypassSpamChecks()
	{
		return $this->bypass_spam_checks;
	}

	public function setBypassSpamChecks($bypass_spam_checks)
	{
		$this->bypass_spam_checks = $bypass_spam_checks;
	}

	public function getBypassVirusChecks()
	{
		return $this->bypass_virus_checks;
	}

	public function setBypassVirusChecks($bypass_virus_checks)
	{
		$this->bypass_virus_checks = $bypass_virus_checks;
	}

	public function getDomain()
	{
		return $this->domain;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getMessageSizeLimit()
	{
		return $this->message_size_limit;
	}

	public function setMessageSizeLimit($message_size_limit)
	{
		$this->message_size_limit = $message_size_limit;
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

	public function getSpamKillLevel()
	{
		return $this->spam_kill_level;
	}

	public function setSpamKillLevel($spam_kill_level)
	{
		$this->spam_kill_level = $spam_kill_level;
	}

	public function getSpamLover()
	{
		return $this->spam_lover;
	}

	public function setSpamLover($spam_lover)
	{
		$this->spam_lover = $spam_lover;
	}

	public function getSpamQuarantineCutoffLevel()
	{
		return $this->spam_quarantine_cutoff_level;
	}

	public function setSpamQuarantineCutoffLevel($spam_quarantine_cutoff_level)
	{
		$this->spam_quarantine_cutoff_level = $spam_quarantine_cutoff_level;
	}

	public function getSpamQuarantineTo()
	{
		return $this->spam_quarantine_to;
	}

	public function setSpamQuarantineTo($spam_quarantine_to)
	{
		$this->spam_quarantine_to = $spam_quarantine_to;
	}

	public function getSpamSubjectTag()
	{
		return $this->spam_subject_tag;
	}

	public function setSpamSubjectTag($spam_subject_tag)
	{
		$this->spam_subject_tag = $spam_subject_tag;
	}

	public function getSpamSubjectTag2()
	{
		return $this->spam_subject_tag2;
	}

	public function setSpamSubjectTag2($spam_subject_tag2)
	{
		$this->spam_subject_tag2 = $spam_subject_tag2;
	}

	public function getSpamSubjectTag3()
	{
		return $this->spam_subject_tag3;
	}

	public function setSpamSubjectTag3($spam_subject_tag3)
	{
		$this->spam_subject_tag3 = $spam_subject_tag3;
	}

	public function getSpamTag2Level()
	{
		return $this->spam_tag2_level;
	}

	public function setSpamTag2Level($spam_tag2_level)
	{
		$this->spam_tag2_level = $spam_tag2_level;
	}

	public function getSpamTag3Level()
	{
		return $this->spam_tag3_level;
	}

	public function setSpamTag3Level($spam_tag3_level)
	{
		$this->spam_tag3_level = $spam_tag3_level;
	}

	public function getSpamTagLevel()
	{
		return $this->spam_tag_level;
	}

	public function setSpamTagLevel($spam_tag_level)
	{
		$this->spam_tag_level = $spam_tag_level;
	}

	public function getUncheckedLover()
	{
		return $this->unchecked_lover;
	}

	public function setUncheckedLover($unchecked_lover)
	{
		$this->unchecked_lover = $unchecked_lover;
	}

	public function getUncheckedQuarantineTo()
	{
		return $this->unchecked_quarantine_to;
	}

	public function setUncheckedQuarantineTo($unchecked_quarantine_to)
	{
		$this->unchecked_quarantine_to = $unchecked_quarantine_to;
	}

	public function getVirusLover()
	{
		return $this->virus_lover;
	}

	public function setVirusLover($virus_lover)
	{
		$this->virus_lover = $virus_lover;
	}

	public function getVirusQuarantineTo()
	{
		return $this->virus_quarantine_to;
	}

	public function setVirusQuarantineTo($virus_quarantine_to)
	{
		$this->virus_quarantine_to = $virus_quarantine_to;
	}

	public function getWarnbadhrecip()
	{
		return $this->warnbadhrecip;
	}

	public function setWarnbadhrecip($warnbadhrecip)
	{
		$this->warnbadhrecip = $warnbadhrecip;
	}

	public function getWarnbannedrecip()
	{
		return $this->warnbannedrecip;
	}

	public function setWarnbannedrecip($warnbannedrecip)
	{
		$this->warnbannedrecip = $warnbannedrecip;
	}

	public function getWarnvirusrecip()
	{
		return $this->warnvirusrecip;
	}

	public function setWarnvirusrecip($warnvirusrecip)
	{
		$this->warnvirusrecip = $warnvirusrecip;
	}

}
