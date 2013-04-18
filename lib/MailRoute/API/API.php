<?php
namespace MailRoute\API;

interface API
{
	/** @return Interfaces\IResourceAdmins */
	public function Admins();

	/** @return Interfaces\IResourceBrandinginfo */
	public function Brandinginfo();

	/** @return Interfaces\IResourceContactCustomer */
	public function ContactCustomer();

	/** @return Interfaces\IResourceContactDomain */
	public function ContactDomain();

	/** @return Interfaces\IResourceContactEmailAccount */
	public function ContactEmailAccount();

	/** @return Interfaces\IResourceContactReseller */
	public function ContactReseller();

	/** @return Interfaces\IResourceCustomer */
	public function Customer();

	/** @return Interfaces\IResourceDomain */
	public function Domain();

	/** @return Interfaces\IResourceDomainAlias */
	public function DomainAlias();

	/** @return Interfaces\IResourceDomainWithAlias */
	public function DomainWithAlias();

	/** @return Interfaces\IResourceEmailAccount */
	public function EmailAccount();

	/** @return Interfaces\IResourceLocalpartAlias */
	public function LocalpartAlias();

	/** @return Interfaces\IResourceMailServer */
	public function MailServer();

	/** @return Interfaces\IResourceMailaddr */
	public function Mailaddr();

	/** @return Interfaces\IResourceNotificationAccountTask */
	public function NotificationAccountTask();

	/** @return Interfaces\IResourceNotificationDomainTask */
	public function NotificationDomainTask();

	/** @return Interfaces\IResourceOutboundServer */
	public function OutboundServer();

	/** @return Interfaces\IResourcePolicyDomain */
	public function PolicyDomain();

	/** @return Interfaces\IResourcePolicyUser */
	public function PolicyUser();

	/** @return Interfaces\IResourceQuarantineMessage */
	public function QuarantineMessage();

	/** @return Interfaces\IResourceReseller */
	public function Reseller();

	/** @return Interfaces\IResourceWblist */
	public function Wblist();

}
