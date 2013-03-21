<?php
namespace MailRoute\API;

interface API
{
	/** @return IEntity */
	public function Admins();

	/** @return IEntity */
	public function BrandingInfo();

	/** @return IEntity */
	public function Contact_customer();

	/** @return IEntity */
	public function Contact_domain();

	/** @return IEntity */
	public function Contact_email_account();

	/** @return IEntity */
	public function Contact_reseller();

	/** @return IEntity */
	public function Customer();

	/** @return IEntity */
	public function Domain();

	/** @return IEntity */
	public function Domain_alias();

	/** @return IEntity */
	public function Domain_with_alias();

	/** @return IEntity */
	public function Email_account();

	/** @return IEntity */
	public function LocalPart_alias();

	/** @return IEntity */
	public function Mail_server();

	/** @return IEntity */
	public function Notification_account_task();

	/** @return IEntity */
	public function Notification_domain_task();

	/** @return IEntity */
	public function Outbound_server();

	/** @return IEntity */
	public function Policy_domain();

	/** @return IEntity */
	public function Policy_user();

	/** @return IEntity */
	public function Quarantine();

	/** @return IEntity */
	public function Quarantine_message();

	/** @return IEntity */
	public function Quarantine_readonly();

	/** @return IEntity */
	public function Quarantine_readonly_message();

	/** @return IEntity */
	public function Reseller();

	/** @return IEntity */
	public function WbList();

}
