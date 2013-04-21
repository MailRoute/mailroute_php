<?php
namespace MailRoute\API\Tests;

use Jamm\Tester\ClassTest;
use MailRoute\API\AccessDeniedException;
use MailRoute\API\Config;
use MailRoute\API\IClient;

class TestAccess extends ClassTest
{
	/** @var Config */
	private $RootConfig;
	/** @var IClient */
	private $Client;
	/** @var Config */
	private $InitialConfig;

	public function __construct(Config $Config)
	{
		$this->InitialConfig = $Config;
	}

	public function setUp()
	{
		$this->RootConfig = clone $this->InitialConfig;
		$this->Client     = new ClientMock($this->RootConfig);
	}

	public function testResellerAdmin()
	{
		$reseller_name       = 'reseller'.md5(microtime(1).mt_rand(1, 9999));
		$Reseller            = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$ForeignReseller     = $this->Client->API()->Reseller()->create(array('name' => 'f'.$reseller_name));
		$Admin               = $Reseller->createAdmin('admin'.$reseller_name.'@example.com', 0, 'admin'.$reseller_name);
		$Customer            = $Reseller->createCustomer('customer'.$reseller_name);
		$ForeignCustomer     = $ForeignReseller->createCustomer('foreign_customer'.$reseller_name);
		$Domain              = $Customer->createDomain('domain'.md5($reseller_name).'.example.com');
		$ForeignDomain       = $ForeignCustomer->createDomain('domain'.md5($ForeignCustomer->getName()).'.example.com');
		$EmailAccount        = $Domain->createEmailAccount('email'.md5($reseller_name));
		$ForeignEmailAccount = $ForeignDomain->createEmailAccount('email'.md5($ForeignReseller->getName()));
		$this->Client        = $this->getClientForUser($Admin->getUsername(), $Admin->regenerateApiKey());
		$this->assertEquals($this->Client, $Admin->getAPIClient());
		$this->assertEquals($this->Client, $Reseller->getAPIClient());
		// allowed
		try
		{
			$Reseller->setName($reseller_name.'change');
			$this->assertTrue($Reseller->save());
			$Admin->setUsername($Admin->getUsername().'change');
			$this->assertTrue($Admin->save());
			$Customer->setAllowBranding(!$Customer->getAllowBranding());
			$this->assertTrue($Customer->save());
			$Domain->setOutboundEnabled(!$Domain->getOutboundEnabled());
			$this->assertTrue($Domain->save());
			$EmailAccount->setPriority(15);
			$this->assertTrue($EmailAccount->save());
		}
		catch (AccessDeniedException $Exception)
		{
			$this->assertTrue(false)->addCommentary("Access denied: ".$Exception->getMessage());
		}
		// not allowed
		// reseller
		try
		{
			$ForeignReseller->setName($ForeignReseller->getName().'change');
			$result = $ForeignReseller->save();
			$this->assertTrue(!$result)->addCommentary("Can change foreign reseller name");
			$this->assertTrue(false)->addCommentary("403 exception wasn't thrown!");
		}
		catch (AccessDeniedException $Exception)
		{
			$this->assertTrue(true);
		}
		// customer
		try
		{
			$ForeignCustomer->setAllowBranding(!$ForeignCustomer->getAllowBranding());
			$result = $ForeignCustomer->save();
			$this->assertTrue(!$result)->addCommentary("Can change foreign customer data");
			$this->assertTrue(false)->addCommentary("403 exception wasn't thrown!");
		}
		catch (AccessDeniedException $Exception)
		{
			$this->assertTrue(true);
		}
		// Domain
		try
		{
			$ForeignDomain->setOutboundEnabled(!$ForeignDomain->getOutboundEnabled());
			$result = $ForeignDomain->save();
			$this->assertTrue(!$result)->addCommentary("Can change foreign domain data");
			$this->assertTrue(false)->addCommentary("403 exception wasn't thrown!");
		}
		catch (AccessDeniedException $Exception)
		{
			$this->assertTrue(true);
		}
		// EmailAccount
		try
		{
			$ForeignEmailAccount->setPriority(20);
			$result = $ForeignEmailAccount->save();
			$this->assertTrue(!$result)->addCommentary("Can change foreign email account data");
			$this->assertTrue(false)->addCommentary("403 exception wasn't thrown!");
		}
		catch (AccessDeniedException $Exception)
		{
			$this->assertTrue(true);
		}
		$EmailAccount->delete();
		$Domain->delete();
		$Customer->delete();
		$Admin->delete();
		$Reseller->delete();
		$ForeignEmailAccount->delete();
		$ForeignDomain->delete();
		$ForeignCustomer->delete();
		$ForeignReseller->delete();
	}

	public function testCustomerAdmin()
	{
		$reseller_name       = 'reseller'.md5(microtime(1).mt_rand(1, 9999));
		$Reseller            = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$ForeignReseller     = $this->Client->API()->Reseller()->create(array('name' => 'f'.$reseller_name));
		$Customer            = $Reseller->createCustomer('customer'.md5($reseller_name));
		$ForeignCustomer     = $ForeignReseller->createCustomer('customer'.md5($ForeignReseller->getName()));
		$Admin               = $Customer->createAdmin('admin'.$Customer->getName().'@example.com', 0, 'admin'.$Customer->getName());
		$ForeignAdmin        = $ForeignCustomer->createAdmin('admin'.$ForeignCustomer->getName().'@example.com', 0, 'admin'.$ForeignCustomer->getName());
		$Domain              = $Customer->createDomain('domain'.md5($Customer->getName()).'.example.com');
		$ForeignDomain       = $ForeignCustomer->createDomain('domain'.md5($ForeignCustomer->getName()).'.example.com');
		$EmailAccount        = $Domain->createEmailAccount('email'.md5($Customer->getName()));
		$ForeignEmailAccount = $ForeignDomain->createEmailAccount('email'.md5($ForeignCustomer->getName()));
		$this->Client        = $this->getClientForUser($Admin->getUsername(), $Admin->regenerateApiKey());
		// allowed actions
		try
		{
			$EmailAccount->setPriority(10);
			$this->assertTrue($EmailAccount->save());
			$Domain->setOutboundEnabled(!$Domain->getOutboundEnabled());
			$this->assertTrue($Domain->save());
			$Admin->setIsActive(!$Admin->getIsActive());
			$this->assertTrue($Admin->save());
			$Customer->setAllowBranding(!$Customer->getAllowBranding());
			$this->assertTrue($Customer->save());
		}
		catch (AccessDeniedException $E)
		{
			$this->assertTrue(false)->addCommentary('Access error: '.$E->getMessage());
		}
		// not allowed actions
		// foreign reseller
		try
		{
			$ForeignReseller->setAllowCustomerBranding(!$ForeignReseller->getAllowCustomerBranding());
			$result = $ForeignReseller->save();
			$this->assertTrue(!$result)->addCommentary("shouldn't be able to change foreign reseller data");
			$this->assertTrue(false)->addCommentary("403 exception wasn't thrown!");
		}
		catch (AccessDeniedException $E)
		{
			$this->assertTrue(true);
		}
		// reseller
		try
		{
			$Reseller->setAllowCustomerBranding(!$Reseller->getAllowCustomerBranding());
			$result = $Reseller->save();
			$this->assertTrue(!$result)->addCommentary("shouldn't be able to change reseller data");
			$this->assertTrue(false)->addCommentary("403 exception wasn't thrown!");
		}
		catch (AccessDeniedException $E)
		{
			$this->assertTrue(true);
		}
		// foreign customer
		try
		{
			$ForeignCustomer->setAllowBranding(!$ForeignCustomer->getAllowBranding());
			$result = $ForeignCustomer->save();
			$this->assertTrue(!$result)->addCommentary("shouldn't be able to change foreign customer data");
			$this->assertTrue(false)->addCommentary("403 exception wasn't thrown!");
		}
		catch (AccessDeniedException $E)
		{
			$this->assertTrue(true);
		}
		// foreign admin
		try
		{
			$ForeignAdmin->setSendWelcome(!$ForeignAdmin->getSendWelcome());
			$result = $ForeignAdmin->save();
			$this->assertTrue(!$result)->addCommentary("shouldn't be able to change foreign admin data");
			$this->assertTrue(false)->addCommentary("403 exception wasn't thrown!");
		}
		catch (AccessDeniedException $E)
		{
			$this->assertTrue(true);
		}
		// foreign domain
		try
		{
			$ForeignDomain->setOutboundEnabled(!$ForeignDomain->getOutboundEnabled());
			$result = $ForeignDomain->save();
			$this->assertTrue(!$result)->addCommentary("shouldn't be able to change foreign domain data");
			$this->assertTrue(false)->addCommentary("403 exception wasn't thrown!");
		}
		catch (AccessDeniedException $E)
		{
			$this->assertTrue(true);
		}
		// foreign email account
		try
		{
			$ForeignEmailAccount->setPriority(50);
			$result = $ForeignEmailAccount->save();
			$this->assertTrue(!$result)->addCommentary("shouldn't be able to change foreign email account data");
			$this->assertTrue(false)->addCommentary("403 exception wasn't thrown!");
		}
		catch (AccessDeniedException $E)
		{
			$this->assertTrue(true);
		}
		$EmailAccount->delete();
		$Domain->delete();
		$Admin->delete();
		$Customer->delete();
		$Reseller->delete();
		$ForeignEmailAccount->delete();
		$ForeignDomain->delete();
		$ForeignAdmin->delete();
		$ForeignCustomer->delete();
		$ForeignReseller->delete();
	}

	public function testEmailAccount()
	{
		$reseller_name       = 'reseller'.md5(microtime(1).mt_rand(1, 9999));
		$Reseller            = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$ForeignReseller     = $this->Client->API()->Reseller()->create(array('name' => 'f'.$reseller_name));
		$Customer            = $Reseller->createCustomer('customer'.md5($reseller_name));
		$ForeignCustomer     = $ForeignReseller->createCustomer('customer'.md5($ForeignReseller->getName()));
		$Admin               = $Customer->createAdmin('admin'.$Customer->getName().'@example.com', 0, 'admin'.$Customer->getName());
		$ForeignAdmin        = $ForeignCustomer->createAdmin('admin'.$ForeignCustomer->getName().'@example.com', 0, 'admin'.$ForeignCustomer->getName());
		$Domain              = $Customer->createDomain('domain'.md5($Customer->getName()).'.example.com');
		$ForeignDomain       = $ForeignCustomer->createDomain('domain'.md5($ForeignCustomer->getName()).'.example.com');
		$EmailAccount        = $Domain->createEmailAccount('email'.md5($Customer->getName()));
		$ForeignEmailAccount = $ForeignDomain->createEmailAccount('email'.md5($ForeignCustomer->getName()));
		$this->Client        = $this->getClientForUser($EmailAccount->getId(), $EmailAccount->regenerateApiKey());
		// allowed actions
		try
		{
			$EmailAccount->setPriority(10);
			$this->assertTrue($EmailAccount->save());
		}
		catch (AccessDeniedException $E)
		{
			$this->assertTrue(false)->addCommentary('Access error: '.$E->getMessage());
		}
		// not allowed actions
		// Customer
		try
		{
			$Customer->setAllowBranding(!$Customer->getAllowBranding());
			$result = $Customer->save();
			$this->assertTrue(!$result)->addCommentary("shouldn't be able to change customer data");
			$this->assertTrue(false)->addCommentary("403 exception wasn't thrown!");
		}
		catch (AccessDeniedException $E)
		{
			$this->assertTrue(true);
		}
		// Admin
		try
		{
			$Admin->setIsActive(!$Admin->getIsActive());
			$result = $Admin->save();
			$this->assertTrue(!$result)->addCommentary("shouldn't be able to change admin data");
			$this->assertTrue(false)->addCommentary("403 exception wasn't thrown!");
		}
		catch (AccessDeniedException $E)
		{
			$this->assertTrue(true);
		}
		// domain
		try
		{
			$Domain->setOutboundEnabled(!$Domain->getOutboundEnabled());
			$result = $Domain->save();
			$this->assertTrue(!$result)->addCommentary("shouldn't be able to change domain data");
			$this->assertTrue(false)->addCommentary("403 exception wasn't thrown!");
		}
		catch (AccessDeniedException $E)
		{
			$this->assertTrue(true);
		}
		// foreign reseller
		try
		{
			$ForeignReseller->setAllowCustomerBranding(!$ForeignReseller->getAllowCustomerBranding());
			$result = $ForeignReseller->save();
			$this->assertTrue(!$result)->addCommentary("shouldn't be able to change foreign reseller data");
			$this->assertTrue(false)->addCommentary("403 exception wasn't thrown!");
		}
		catch (AccessDeniedException $E)
		{
			$this->assertTrue(true);
		}
		// reseller
		try
		{
			$Reseller->setAllowCustomerBranding(!$Reseller->getAllowCustomerBranding());
			$result = $Reseller->save();
			$this->assertTrue(!$result)->addCommentary("shouldn't be able to change reseller data");
			$this->assertTrue(false)->addCommentary("403 exception wasn't thrown!");
		}
		catch (AccessDeniedException $E)
		{
			$this->assertTrue(true);
		}
		// foreign customer
		try
		{
			$ForeignCustomer->setAllowBranding(!$ForeignCustomer->getAllowBranding());
			$result = $ForeignCustomer->save();
			$this->assertTrue(!$result)->addCommentary("shouldn't be able to change foreign customer data");
			$this->assertTrue(false)->addCommentary("403 exception wasn't thrown!");
		}
		catch (AccessDeniedException $E)
		{
			$this->assertTrue(true);
		}
		// foreign admin
		try
		{
			$ForeignAdmin->setSendWelcome(!$ForeignAdmin->getSendWelcome());
			$result = $ForeignAdmin->save();
			$this->assertTrue(!$result)->addCommentary("shouldn't be able to change foreign admin data");
			$this->assertTrue(false)->addCommentary("403 exception wasn't thrown!");
		}
		catch (AccessDeniedException $E)
		{
			$this->assertTrue(true);
		}
		// foreign domain
		try
		{
			$ForeignDomain->setOutboundEnabled(!$ForeignDomain->getOutboundEnabled());
			$result = $ForeignDomain->save();
			$this->assertTrue(!$result)->addCommentary("shouldn't be able to change foreign domain data");
			$this->assertTrue(false)->addCommentary("403 exception wasn't thrown!");
		}
		catch (AccessDeniedException $E)
		{
			$this->assertTrue(true);
		}
		// foreign email account
		try
		{
			$ForeignEmailAccount->setPriority(50);
			$result = $ForeignEmailAccount->save();
			$this->assertTrue(!$result)->addCommentary("shouldn't be able to change foreign email account data");
			$this->assertTrue(false)->addCommentary("403 exception wasn't thrown!");
		}
		catch (AccessDeniedException $E)
		{
			$this->assertTrue(true);
		}
		$EmailAccount->delete();
		$Domain->delete();
		$Admin->delete();
		$Customer->delete();
		$Reseller->delete();
		$ForeignEmailAccount->delete();
		$ForeignDomain->delete();
		$ForeignAdmin->delete();
		$ForeignCustomer->delete();
		$ForeignReseller->delete();
	}

	protected function getClientForUser($user, $password)
	{
		$Config           = clone $this->RootConfig;
		$Config->login    = $user;
		$Config->password = $password;
		$Client           = new ClientMock($Config);
		return $Client;
	}
}
