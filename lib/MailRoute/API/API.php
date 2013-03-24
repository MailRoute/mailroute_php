<?php
namespace MailRoute\API;

interface API
{
	/** @return IResource */
	public function Admins();

	/** @return IResource */
	public function Brandinginfo();

	/** @return IResource */
	public function ContactCustomer();

	/** @return IResource */
	public function ContactDomain();

	/** @return IResource */
	public function ContactEmailAccount();

	/** @return IResource */
	public function ContactReseller();

	/** @return IResource */
	public function Customer();

	/** @return IResource */
	public function Domain();

	/** @return IResource */
	public function DomainAlias();

	/** @return IResource */
	public function DomainWithAlias();

	/** @return IResource */
	public function EmailAccount();

	/** @return IResource */
	public function LocalpartAlias();

	/** @return IResource */
	public function MailServer();

	/** @return IResource */
	public function NotificationAccountTask();

	/** @return IResource */
	public function NotificationDomainTask();

	/** @return IResource */
	public function OutboundServer();

	/** @return IResource */
	public function PolicyDomain();

	/** @return IResource */
	public function PolicyUser();

	/** @return IResource */
	public function Quarantine();

	/** @return IResource */
	public function QuarantineMessage();

	/** @return IResource */
	public function QuarantineReadonly();

	/** @return IResource */
	public function QuarantineReadonlyMessage();

	/** @return IResource */
	public function Reseller();

	/** @return IResource */
	public function Wblist();

}
