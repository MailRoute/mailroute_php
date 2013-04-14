<?php
namespace MailRoute\API\Tests;

use Jamm\Tester\ClassTest;
use MailRoute\API\AntiSpamMode;
use MailRoute\API\Entity\Admins;
use MailRoute\API\Entity\ContactReseller;
use MailRoute\API\Entity\Customer;
use MailRoute\API\Entity\Domain;
use MailRoute\API\Entity\EmailAccount;
use MailRoute\API\Entity\Reseller;
use MailRoute\API\Exception;
use MailRoute\API\IActiveEntity;
use MailRoute\API\IClient;
use MailRoute\API\NotFoundException;
use MailRoute\API\ValidationException;

class TestClient extends ClassTest
{
	/** @var ClientMock */
	private $Client;

	public function __construct(IClient $Client)
	{
		$this->Client = $Client;
		$this->Client->setDeleteNotFoundIsError(true);
		$this->skipTest(array('testEmailAccountAddNotificationTask',
			'testDomainAddNotificationTask',
			'testEmailAccountAddNotificationTask',
			'testEmailAccountBulkAddAlias',
			'testDomainGetNotificationTask',
			'testEmailAccountUseDomainNotification'
		));
		$this->skipAllExcept('testResellerCreateAndDeleteAdmin');
	}

	public function testGetRootSchema()
	{
		$result = $this->Client->GET();
		$this->assertIsArray($result);
		$this->assertTrue(isset($result['reseller']));
	}

	public function testSchema()
	{
		$result = $this->Client->GET('reseller/schema');
		$this->assertIsArray($result);
		$this->assertTrue(isset($result['allowed_detail_http_methods']));
	}

	public function testResellerPOST()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1000, 9999);
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$this->assertTrue(is_object($Reseller));
		$this->assertEquals($Reseller->getName(), $reseller_name);
		$result = $this->Client->API()->Reseller()->filter(array('name' => $reseller_name))->fetchList();
		$this->assertIsArray($result);
		$this->assertEquals(count($result), 1);
		$this->assertTrue($Reseller->delete());
	}

	public function testResellerPOSTDuplicate()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1000, 9999);
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		try
		{
			$this->Client->API()->Reseller()->create(array('name' => $reseller_name));
			$this->assertTrue(false)->addCommentary('Duplicate was created successfully');
		}
		catch (Exception $E)
		{
			$this->assertTrue(true);
		}
		$this->assertTrue($Reseller->delete());
	}

	public function testResellerList()
	{
		$reseller_name = 'test '.microtime(1);
		/** @var IActiveEntity[] $resellers */
		$resellers   = array();
		$NewReseller = new Reseller($this->Client);
		$NewReseller->setName($reseller_name.'1');
		$resellers[] = $this->Client->API()->Reseller()->create($NewReseller);
		$resellers[] = $this->Client->API()->Reseller()->create(array('name' => $reseller_name.'2'));
		$resellers[] = $this->Client->API()->Reseller()->create(array('name' => $reseller_name.'3'));
		$resellers[] = $this->Client->API()->Reseller()->create(array('name' => $reseller_name.'4'));
		$resellers[] = $this->Client->API()->Reseller()->create(array('name' => $reseller_name.'5'));
		$resellers[] = $this->Client->API()->Reseller()->create(array('name' => $reseller_name.'6'));
		$result      = $this->Client->API()->Reseller()->offset(1)->limit(5)->fetchList();
		$this->assertIsArray($result);
		$this->assertTrue(count($result)==5)->addCommentary($result);
		foreach ($resellers as $Reseller)
		{
			$this->assertTrue($Reseller->delete());
		}
	}

	public function testContactResellerPOST()
	{
		$email = 'test@example.com';
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => 'test contactReseller '.microtime(1).mt_rand(1000, 9999)));
		$Item     = new ContactReseller($this->Client);
		$Item->setEmail($email);
		$Item->setReseller($Reseller->getResourceUri());
		/** @var ContactReseller $ContactReseller */
		$ContactReseller = $this->Client->API()->ContactReseller()->create($Item);
		$this->assertTrue(is_object($ContactReseller));
		$this->assertEquals($ContactReseller->getEmail(), $email);
		$this->assertEquals($ContactReseller->getReseller()->getResourceUri(), $Reseller->getResourceUri());

		$Item = new ContactReseller($this->Client);
		$Item->setReseller('not_existing');
		try
		{
			$ContactReseller = $this->Client->API()->ContactReseller()->create($Item);
			$this->assertTrue(false);
		}
		catch (Exception $Exception)
		{
			$this->assertTrue(true);
		}

		$this->assertTrue($ContactReseller->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testResellerDELETE()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1000, 9999).'_del';
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$this->assertTrue(is_object($Reseller));
		$this->assertEquals($Reseller->getName(), $reseller_name)->addCommentary($Reseller);
		$result = $Reseller->delete();
		$this->assertTrue($result);
		try
		{
			$result = $this->Client->API()->Reseller()->get($Reseller->getId());
		}
		catch (Exception $E)
		{
			$result = false;
		}
		$this->assertTrue(!$result)->addCommentary(gettype($result).': '.print_r($result, 1));
	}

	public function testResellerPUT()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1000, 9999).'_put';
		/** @var Reseller $Reseller */
		$NewReseller = new Reseller($this->Client);
		$NewReseller->setName($reseller_name);
		$Reseller = $this->Client->API()->Reseller()->create($NewReseller);
		$this->assertEquals($Reseller->getName(), $reseller_name);
		$Reseller->setName($reseller_name.'_updated');
		try
		{
			$Reseller = $this->Client->API()->Reseller()->update($Reseller);
		}
		catch (\Exception $E)
		{
			$this->assertTrue(false);
		}
		$this->assertEquals($Reseller->getName(), $reseller_name.'_updated', true);
		$Reseller->setName($reseller_name.'_saved');
		try
		{
			$Reseller->save();
		}
		catch (\Exception $E)
		{
			$this->assertTrue(false);
		}
		$Reseller = $this->Client->API()->Reseller()->get($Reseller->getId());
		$this->assertEquals($Reseller->getName(), $reseller_name.'_saved', true);
		$this->assertTrue($Reseller->delete());
		$ResellerWithoutID = new Reseller($this->Client);
		try
		{
			$this->Client->API()->Reseller()->update($Reseller);
			$this->assertTrue(false);
		}
		catch (Exception $E)
		{
			$this->assertTrue(true);
		}
		try
		{
			$ResellerWithoutID->save();
			$this->assertTrue(false);
		}
		catch (Exception $E)
		{
			$this->assertTrue(true);
		}
	}

	public function testSearch()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1000, 9999);
		/** @var Reseller[] $resellers */
		$resellers   = array();
		$NewReseller = new Reseller($this->Client);
		$NewReseller->setName($reseller_name.'1');
		$resellers[] = $this->Client->API()->Reseller()->create($NewReseller);
		$NewReseller->setName($reseller_name.'2');
		$resellers[] = $this->Client->API()->Reseller()->create($NewReseller);
		/** @var Reseller[] $result */
		$result = $this->Client->API()->Reseller()->search($reseller_name);
		$this->assertIsArray($result);
		$this->assertIsObject($result[0]);
		$this->assertEquals($result[1]->getResourceURI(), $resellers[1]->getResourceUri());
		foreach ($resellers as $Reseller)
		{
			$this->assertTrue($Reseller->delete());
		}
	}

	public function testResellerCreateAndDeleteAdmin()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1000, 9999).'create_admin';
		$NewReseller   = new Reseller($this->Client);
		$NewReseller->setName($reseller_name);
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create($NewReseller);
		try
		{
			$Admin = $Reseller->createAdmin('test@example.com', 1);
			$this->assertIsObject($Admin);
			$this->assertEquals($Admin->getEmail(), 'test@example.com');
			$this->assertEquals($Admin->getReseller()->getResourceUri(), $Reseller->getResourceUri());
			$this->assertTrue($Reseller->deleteAdmin('test@example.com'));
		}
		catch (Exception $E)
		{
			$this->assertTrue(false)->addCommentary($E->getResponse());
		}
		try
		{
			$Reseller->createAdmin('--', 0);
			$this->assertTrue(false);
		}
		catch (ValidationException $E)
		{
			$this->assertTrue(true);
		}
		$this->assertTrue($Reseller->delete());
	}

	public function testResellerGetContacts()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1000, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		for ($i = 0; $i < 5; $i++)
		{
			$this->Client->API()->ContactReseller()->create(array(
				'reseller' => $this->Client->getAPIPathPrefix().$Reseller->getApiEntityResource().'/'.$Reseller->getId().'/',
				'email'    => 'reseller_contact@example.com'
			));
		}
		$Contacts = $Reseller->getContacts();
		$this->assertIsArray($Contacts);
		$this->assertIsObject($Contacts[0]);
		foreach ($Contacts as $Contact)
		{
			$this->assertTrue($Contact->delete());
		}
		$this->assertTrue($Reseller->delete());
	}

	public function testResellerCreateContact()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1000, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$result   = $Reseller->createContact('contact@example.com');
		$this->assertIsObject($result);
		$this->assertEquals($result->getEmail(), 'contact@example.com');
		$this->assertTrue($result->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testResellerCreateCustomer()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1000, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$result   = $Reseller->createCustomer('customer'.$reseller_name);
		$this->assertIsObject($result);
		$this->assertEquals($result->getName(), 'customer'.$reseller_name);
		$this->assertTrue($result->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testCustomerCreateContact()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer = $Reseller->createCustomer('customer'.$reseller_name);
		$result   = $Customer->createContact('customer@example.com');
		$this->assertIsObject($result);
		$this->assertEquals($result->getEmail(), 'customer@example.com');
		$this->assertTrue($result->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testCustomerCreateAdmin()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer = $Reseller->createCustomer('customer'.$reseller_name);
		$result   = $Customer->createAdmin('admin_customer@example.com');
		$this->assertIsObject($result);
		$this->assertEquals($result->getEmail(), 'admin_customer@example.com');
		$this->assertTrue($result->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testCustomerDeleteAdmin()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller  = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer  = $Reseller->createCustomer('customer'.$reseller_name);
		$adm_email = 'admin_customer'.md5($reseller_name).'@example.com';
		$Customer->createAdmin($adm_email);
		$Customer->createAdmin('2'.$adm_email);
		$result = $Customer->deleteAdmin($adm_email);
		$this->assertTrueStrict($result);
		/** @var Customer $RefreshCustomer */
		$RefreshCustomer = $this->Client->API()->Customer()->get($Customer->getId());
		/** @var Admins[] $new_list */
		$new_list = $RefreshCustomer->getAdmins();
		$this->assertEquals(count($new_list), 1, true);
		$this->assertEquals($new_list[0]->getEmail(), '2'.$adm_email);
		$this->assertTrue($new_list[0]->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testCustomerCreateDomain()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer = $Reseller->createCustomer('customer'.$reseller_name);
		$d        = 'domain'.md5(microtime(1).mt_rand(1, 9999).mt_rand(1, 9999).__LINE__).'.name';
		$result   = $Customer->createDomain($d);
		$this->assertIsObject($result);
		$this->assertEquals($result->getName(), $d);
		$this->assertTrue($result->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testDomainMoveToCustomer()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller  = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer1 = $Reseller->createCustomer('customer1'.$reseller_name);
		$Customer2 = $Reseller->createCustomer('customer2'.$reseller_name);
		$Domain    = $Customer1->createDomain('domain'.md5(microtime(1).mt_rand(1, 9999).__LINE__).'.name');
		$this->assertEquals($Domain->getCustomer()->getResourceUri(), $Customer1->getResourceUri());
		$this->assertEquals($Domain->getCustomer()->getResourceUri(), $Customer1->getResourceUri());
		$result = $Domain->moveToCustomer($Customer2);
		$this->assertTrueStrict($result);
		/** @var Domain $FreshDomain */
		$FreshDomain = $this->Client->API()->Domain()->get($Domain->getId());
		$this->assertEquals($FreshDomain->getCustomer()->getResourceUri(), $Customer2->getResourceUri());
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer2->delete());
		$this->assertTrue($Customer1->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testDomainCreateContact()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain   = $Customer->createDomain('domain'.md5(microtime(1).mt_rand(1, 9999).__LINE__).'.name');

		$email  = 'domain.contact.'.md5($Domain->getResourceUri()).'@example.com';
		$result = $Domain->createContact($email);
		$this->assertIsObject($result);
		$this->assertEquals($result->getEmail(), $email);
		$this->assertTrue($result->delete());
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testDomainCreateMailServer()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain   = $Customer->createDomain('domain'.md5(microtime(1).mt_rand(1, 9999).__LINE__).'.name');

		$result = $Domain->createMailServer('127.0.0.1');
		$this->assertIsObject($result);
		$this->assertEquals($result->getServer(), '127.0.0.1');
		$this->assertTrue($result->delete());
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testDomainCreateOutboundServer()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain   = $Customer->createDomain('domain'.md5(microtime(1).mt_rand(1, 9999).__LINE__).'.name');

		$result = $Domain->createOutboundServer('127.0.0.1');
		$this->assertIsObject($result);
		$this->assertEquals($result->getServer(), '127.0.0.1');
		$this->assertTrue($result->delete());
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testDomainCreateEmailAccount()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain   = $Customer->createDomain('domain'.md5(microtime(1).mt_rand(1, 9999).__LINE__).'.name');

		$lp     = substr(md5(microtime(1).mt_rand(1, 9999).__LINE__), 5);
		$result = $Domain->createEmailAccount($lp);
		$this->assertIsObject($result);
		$this->assertEquals($result->getLocalpart(), $lp);
		$this->assertTrue($result->delete());
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testDomainBulkCreateEmailAccount()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain   = $Customer->createDomain('domain'.md5(microtime(1).mt_rand(1, 9999).__LINE__).'.name');

		$localparts = array();
		for ($i = 0; $i < 5; $i++)
		{
			$localparts[] = array('localpart' => $i);
		}
		$result = $Domain->bulkCreateEmailAccount($localparts);
		$this->assertIsObject($result[0]);
		$this->assertIsObject($result[0]);
		foreach ($result as $key => $EmailAccount)
		{
			if (is_a($EmailAccount, 'MailRoute\\API\\Exception'))
			{
				/** @var Exception $EmailAccount */
				$this->assertTrue(false)->addCommentary('Exception: '.print_r($EmailAccount->getResponse(), 1));
				continue;
			}
			$this->assertEquals($EmailAccount->getLocalpart(), $key);
			$this->assertTrue($EmailAccount->delete());
		}
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testDomainCreateAlias()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain   = $Customer->createDomain('domain'.md5(microtime(1).mt_rand(1, 9999).__LINE__).'.name');

		$name   = 'domain'.md5(microtime(1).mt_rand(1, 9999).__LINE__).'.name';
		$result = $Domain->createAlias($name);
		$this->assertIsObject($result);
		$this->assertEquals($result->getName(), $name);

		$this->assertTrue($result->delete());
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());

	}

	public function testDomainAddToBlackList()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain   = $Customer->createDomain('domain'.md5(microtime(1).mt_rand(1, 9999).__LINE__).'.name');

		$email  = substr(md5(microtime(1).mt_rand(1, 9999).__LINE__), 5).'@example.com';
		$result = $Domain->addToBlackList($email);
		$this->assertIsObject($result);
		$this->assertTrue($result->delete());
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testDomainAddToWhiteList()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain   = $Customer->createDomain('domain'.md5(microtime(1).mt_rand(1, 9999).__LINE__).'.name');

		$email  = substr(md5(microtime(1).mt_rand(1, 9999).__LINE__), 5).'@example.com';
		$result = $Domain->addToWhiteList($email);
		$this->assertIsObject($result);
		$this->assertTrue($result->delete());
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testEmailAccountAddAlias()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller     = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer     = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain       = $Customer->createDomain('domain'.md5(microtime(1).mt_rand(1, 9999).__LINE__).'.name');
		$localpart    = substr(md5(microtime(1).mt_rand(1, 9999).__LINE__), 5);
		$EmailAccount = $Domain->createEmailAccount($localpart);
		$result       = $EmailAccount->addAlias($localpart.'alias');
		$this->assertIsObject($result);
		$this->assertEquals($result->getLocalpart(), $localpart.'alias');
		$this->assertEquals($result->getEmailAccount()->getId(), $EmailAccount->getId());
		$this->assertTrue($result->delete());
		$this->assertTrue($EmailAccount->delete());
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testEmailAccountBulkAddAlias()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller     = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer     = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain       = $Customer->createDomain('domain'.md5(microtime(1).mt_rand(1, 9999).__LINE__).'.name');
		$localpart    = substr(md5(microtime(1).mt_rand(1, 9999).__LINE__), 5);
		$EmailAccount = $Domain->createEmailAccount($localpart);
		$aliases      = array();
		for ($i = 0; $i < 3; $i++)
		{
			$aliases[] = $localpart.'alias'.$i;
		}
		try
		{
			$result = $EmailAccount->bulkAddAlias($aliases);
			$this->assertTrueStrict($result);
			$aliases = $EmailAccount->getLocalpartAliases();
			$this->assertIsObject($aliases[0]);
			foreach ($aliases as $Alias)
			{
				$this->assertEquals($Alias->getEmailAccount()->getResourceUri(), $EmailAccount->getResourceUri());
				$this->assertTrue($Alias->delete());
			}
		}
		catch (Exception $E)
		{
			$this->assertTrue(false)->addCommentary($E->getMessage());
		}
		$this->assertTrue($EmailAccount->delete());
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testEmailAccountAddToBlackList()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller     = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer     = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain       = $Customer->createDomain('domain'.md5(microtime(1).mt_rand(1, 9999).__LINE__).'.name');
		$localpart    = substr(md5(microtime(1).mt_rand(1, 9999).__LINE__), 5);
		$EmailAccount = $Domain->createEmailAccount($localpart);

		$blacklisted_email = $localpart.'@example.com';
		$result            = $EmailAccount->addToBlackList($blacklisted_email);
		$this->assertIsObject($result);
		$this->assertEquals($result->getEmail(), $blacklisted_email);
		$this->assertEquals($result->getEmailAccount()->getResourceUri(), $EmailAccount->getResourceUri());
		$this->assertTrue($result->delete());
		$this->assertTrue($EmailAccount->delete());
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testEmailAccountAddToWhiteList()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller     = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer     = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain       = $Customer->createDomain('domain'.md5(microtime(1).mt_rand(1, 9999).__LINE__).'.name');
		$localpart    = substr(md5(microtime(1).mt_rand(1, 9999).__LINE__), 5);
		$EmailAccount = $Domain->createEmailAccount($localpart);

		$whitelisted_email = $localpart.'@example.com';
		$result            = $EmailAccount->addToWhiteList($whitelisted_email);
		$this->assertIsObject($result);
		$this->assertEquals($result->getEmail(), $whitelisted_email);
		$this->assertEquals($result->getEmailAccount()->getResourceUri(), $EmailAccount->getResourceUri());
		$this->assertTrue($result->delete());
		$this->assertTrue($EmailAccount->delete());
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testEmailAccountMakeAliasesFrom()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller     = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer     = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain       = $Customer->createDomain('domain'.md5(microtime(1).mt_rand(1, 9999).__LINE__).'.name');
		$localpart    = substr(md5(microtime(1).mt_rand(1, 9999).__LINE__), 5);
		$EmailAccount = $Domain->createEmailAccount($localpart);

		$to_aliases = array();
		foreach (range(1, 5) as $i)
		{
			$to_aliases[] = $Domain->createEmailAccount($localpart.$i);
		}

		try
		{
			$result = $EmailAccount->makeAliasesFrom($to_aliases);
			$this->assertTrue($result);
		}
		catch (Exception $E)
		{
			$this->assertTrue(false)->addCommentary($E->getResponse());
		}
		$aliases = $EmailAccount->getLocalpartAliases();
		$this->assertEquals(count($aliases), 5);
		$this->assertEquals($aliases[0]->getEmailAccount()->getResourceUri(), $EmailAccount->getResourceUri());
		$this->assertTrue($EmailAccount->delete());
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testResellerDeleteContact()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1000, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$email    = 'contact@example.com';
		$Contact  = $Reseller->createContact($email);
		try
		{
			$result = $Reseller->deleteContact($email);
		}
		catch (Exception $E)
		{
			$this->assertTrue(false)->addCommentary($E->getResponse());
			$Reseller->delete();
			return false;
		}
		$this->assertEquals($result, 1);
		try
		{
			$this->Client->API()->ContactReseller()->get($Contact->getId());
			$this->assertTrue(false)->addCommentary('was not deleted');
		}
		catch (NotFoundException $Exception)
		{
			$this->assertTrue(true);
		}
		$this->assertTrue($Reseller->delete());
	}

	public function testCustomerDeleteContact()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer = $Reseller->createCustomer('customer'.$reseller_name);
		$email    = 'customer@example.com';
		$Contact  = $Customer->createContact($email);
		$result   = $Customer->deleteContact($email);
		try
		{
			$this->Client->API()->ContactCustomer()->get($Contact->getId());
			$this->assertTrue(false)->addCommentary('was not deleted');
		}
		catch (NotFoundException $Exception)
		{
			$this->assertTrue(true);
		}
		$this->assertEquals($result, 1);

		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testDomainDeleteContact()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain   = $Customer->createDomain('domain'.md5(microtime(1).mt_rand(1, 9999).__LINE__).'.name');
		$email    = 'domain.contact.'.md5($Domain->getResourceUri()).'@example.com';
		$Contact  = $Domain->createContact($email);
		$result   = $Domain->deleteContact($email);
		$this->assertEquals($result, 1);
		try
		{
			$this->Client->API()->ContactDomain()->get($Contact->getId());
			$this->assertTrue(false)->addCommentary('was not deleted');
		}
		catch (NotFoundException $E)
		{
			$this->assertTrue(true);
		}
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testEmailAccountRegenerateApiKey()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller     = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer     = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain       = $Customer->createDomain('domain'.md5(microtime(1).mt_rand(1, 9999).__LINE__).'.name');
		$localpart    = substr(md5(microtime(1).mt_rand(1, 9999).__LINE__), 5);
		$EmailAccount = $Domain->createEmailAccount($localpart);

		$result = $EmailAccount->regenerateApiKey();

		$this->assertTrue($result!==false)->addCommentary($result);
		$this->assertTrue($EmailAccount->delete());
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());

	}

	public function testEmailAccountUseDomainPolicy()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller     = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer     = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain       = $Customer->createDomain('domain'.md5(microtime(1).mt_rand(1, 9999).__LINE__).'.name');
		$localpart    = substr(md5(microtime(1).mt_rand(1, 9999).__LINE__), 5);
		$EmailAccount = $Domain->createEmailAccount($localpart);
		$Domain->setUserlistComplete(1);
		$Domain->save();
		try
		{
			$result = $EmailAccount->useDomainPolicy();
		}
		catch (Exception $E)
		{
			$this->assertTrue(false)->addCommentary($E->getMessage());
			$EmailAccount->delete();
			$Domain->delete();
			$Customer->delete();
			$Reseller->delete();
			return false;
		}
		$this->assertTrue($result);
		$SelfPolicy = $EmailAccount->getPolicy();
		$this->assertTrue($SelfPolicy->getUseDomainPolicy());
		$Policy = $EmailAccount->getActivePolicy();
		$this->assertEquals($Policy->getResourceUri(), $Domain->getPolicy()->getResourceUri());
		$this->assertInstanceOf($Policy, 'MailRoute\\API\\Entity\\PolicyDomain');

		$this->assertTrue($EmailAccount->delete());
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testEmailAccountUseSelfPolicy()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller     = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer     = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain       = $Customer->createDomain('domain'.md5(microtime(1).mt_rand(1, 9999).__LINE__).'.name');
		$localpart    = substr(md5(microtime(1).mt_rand(1, 9999).__LINE__), 5);
		$EmailAccount = $Domain->createEmailAccount($localpart);
		$Domain->setUserlistComplete(1);
		$Domain->save();

		try
		{
			$result = $EmailAccount->useSelfPolicy();
		}
		catch (Exception $E)
		{
			$this->assertTrue(false)->addCommentary($E->getMessage());
			$EmailAccount->delete();
			$Domain->delete();
			$Customer->delete();
			$Reseller->delete();
			return false;
		}
		$this->assertTrue($result);
		$SelfPolicy = $EmailAccount->getPolicy();
		$this->assertTrue(!$SelfPolicy->getUseDomainPolicy());
		$Policy = $EmailAccount->getActivePolicy();
		$this->assertTrue($Policy->getResourceUri()!=$Domain->getPolicy()->getResourceUri());
		$this->assertInstanceOf($Policy, 'MailRoute\\API\\Entity\\PolicyUser');

		$this->assertTrue($EmailAccount->delete());
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testEmailAccountGetActivePolicy()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller     = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer     = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain       = $Customer->createDomain('domain'.md5(microtime(1).mt_rand(1, 9999).__LINE__).'.name');
		$localpart    = substr(md5(microtime(1).mt_rand(1, 9999).__LINE__), 5);
		$EmailAccount = $Domain->createEmailAccount($localpart);
		$Domain->setUserlistComplete(1);
		$Domain->save();
		$EmailAccount->useDomainPolicy();
		$result = $EmailAccount->getActivePolicy();
		$this->assertInstanceOf($result, 'MailRoute\\API\\Entity\\PolicyDomain');
		$this->assertEquals($result->getResourceUri(), $Domain->getPolicy()->getResourceUri());
		$EmailAccount->useSelfPolicy();
		$result = $EmailAccount->getActivePolicy();
		$this->assertInstanceOf($result, 'MailRoute\\API\\Entity\\PolicyUser');
		$this->assertTrue($EmailAccount->delete());
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testEmailAccountUseDomainNotification()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller     = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer     = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain       = $Customer->createDomain('domain'.md5(microtime(1).mt_rand(1, 9999).__LINE__).'.name');
		$localpart    = substr(md5(microtime(1).mt_rand(1, 9999).__LINE__), 5);
		$EmailAccount = $Domain->createEmailAccount($localpart);

		$this->assertTrue($EmailAccount->useDomainNotifications());
		$result = $EmailAccount->getActiveNotificationTasks();
		$this->assertIsArray($result);
		$this->assertInstanceOf($result[0], 'MailRoute\\API\\Entity\\NotificationDomainTask');

		$this->assertTrue($EmailAccount->useSelfNotifications());
		$result = $EmailAccount->getActiveNotificationTasks();
		$this->assertIsArray($result);
		$this->assertInstanceOf($result[0], 'MailRoute\\API\\Entity\\NotificationAccountTask');

		$this->assertTrue($EmailAccount->delete());
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testEmailAccountCreate()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller    = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer    = $Reseller->createCustomer('customer'.$reseller_name);
		$domain_name = 'domain'.md5(microtime(1).mt_rand(1, 9999).__LINE__).'.name';
		$Domain      = $Customer->createDomain($domain_name);
		/** @var EmailAccount $result */
		$result = $this->Client->API()->EmailAccount()->create(array('email' => 'email@'.$domain_name));
		$this->assertInstanceOf($result, 'MailRoute\\API\\Entity\\EmailAccount');
		$this->assertEquals($result->getLocalpart(), 'email');
		$this->assertEquals($result->getDomain()->getResourceUri(), $Domain->getResourceUri());

		$result = $this->Client->API()->EmailAccount()->create(array('email' => 'email2@example.com', 'domain' => $Domain->getResourceUri()));
		$this->assertInstanceOf($result, 'MailRoute\\API\\Entity\\EmailAccount');
		$this->assertEquals($result->getLocalpart(), 'email2');
		$this->assertEquals($result->getDomain()->getResourceUri(), $Domain->getResourceUri());

		try
		{
			$this->Client->API()->EmailAccount()->create(array('email' => 'email@not_existing_example.com'));
			$this->assertTrue(false)->addCommentary('exception expected');
		}
		catch (NotFoundException $E)
		{
			$this->assertTrue(true);
		}

		$this->assertTrue($result->delete());
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testEmailAccountMassDelete()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller     = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer     = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain       = $Customer->createDomain('domain'.md5(microtime(1).mt_rand(1, 9999).__LINE__).'.name');
		$localpart    = substr(md5(microtime(1).mt_rand(1, 9999).__LINE__), 5);
		$EmailAccount = $Domain->createEmailAccount($localpart);
		$id_list[]    = $EmailAccount->getId();
		foreach (range(1, 3) as $i)
		{
			$localpart    = substr(md5(microtime(1).mt_rand(1, 9999).$i.__LINE__), 5);
			$EmailAccount = $Domain->createEmailAccount($localpart);
			$id_list[]    = $EmailAccount->getId();
		}
		try
		{
			$result = $EmailAccount->massDelete($id_list);
		}
		catch (Exception $E)
		{
			$result = false;
		}
		$this->assertTrue($result);
		foreach ($id_list as $id)
		{
			try
			{
				$result = $this->Client->API()->EmailAccount()->get($id);
				$this->assertTrue(!$result);
			}
			catch (NotFoundException $E)
			{
				$this->assertTrue(true);
			}
		}
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testEmailAccountMassAdd()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller   = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer   = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain     = $Customer->createDomain('domain'.md5(microtime(1).mt_rand(1, 9999).__LINE__).'.name');
		$localparts = array();
		foreach (range(1, 3) as $i)
		{
			$localparts[] = substr(md5(microtime(1).mt_rand(1, 9999).__LINE__), 5).$i;
		}
		try
		{
			$result = $this->Client->API()->EmailAccount()->bulkCreate(array('localparts' => $localparts, 'domain' => $Domain->getResourceUri()));
		}
		catch (Exception $E)
		{
			$result = false;
		}
		$this->assertTrue($result);
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testPolicyEnableDisableMethods()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller     = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer     = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain       = $Customer->createDomain('domain'.md5(microtime(1).mt_rand(1, 9999).__LINE__).'.name');
		$localpart    = substr(md5(microtime(1).mt_rand(1, 9999).__LINE__), 5);
		$EmailAccount = $Domain->createEmailAccount($localpart);
		$EmailAccount->useDomainPolicy();
		/** @var EmailAccount $EmailAccount */
		$EmailAccount = $this->Client->API()->EmailAccount()->get($EmailAccount->getId());
		$Policy       = $EmailAccount->getActivePolicy();
		$this->assertTrue($Policy->enableBadHdrFilter());
		$this->assertEquals($Policy->getBypassHeaderChecks(), 'Y');
		$this->assertTrue($Policy->disableBadHdrFilter());
		$this->assertEquals($Policy->getBypassHeaderChecks(), 'N');

		$this->assertTrue($Policy->enableBannedFilter());
		$this->assertEquals($Policy->getBypassBannedChecks(), 'Y');
		$this->assertTrue($Policy->disableBannedFilter());
		$this->assertEquals($Policy->getBypassBannedChecks(), 'N');

		$this->assertTrue($Policy->enableSpamFiltering());
		$this->assertEquals($Policy->getBypassSpamChecks(), 'Y');
		$this->assertTrue($Policy->disableSpamFiltering());
		$this->assertEquals($Policy->getBypassSpamChecks(), 'N');

		$this->assertTrue($Policy->enableVirusFiltering());
		$this->assertEquals($Policy->getBypassVirusChecks(), 'Y');
		$this->assertTrue($Policy->disableVirusFiltering());
		$this->assertEquals($Policy->getBypassVirusChecks(), 'N');

		$this->assertTrue($Policy->setAntiSpamMode(AntiSpamMode::lenient));

		$this->assertTrue($EmailAccount->delete());
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testResellerGetCustomers()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$this->assertEquals(count($Reseller->getCustomers()), 0);
		$Reseller->createCustomer('customer1'.$reseller_name);
		$Reseller->createCustomer('customer2'.$reseller_name);
		$Reseller->createCustomer('customer3'.$reseller_name);
		$result = $Reseller->getCustomers();
		$this->assertEquals(count($result), 3);
		$this->assertIsObject($result[0]);
		foreach ($result as $Customer)
		{
			$this->assertTrue($Customer->delete());
		}
		$this->assertTrue($Reseller->delete());
	}

	public function testResellerGetBrandingInfo()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$result   = $Reseller->getBrandingInfo();
		$this->assertIsObject($result);
		$Reseller->delete();
	}

	public function testCustomerGetReseller()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer = $Reseller->createCustomer('customer'.$reseller_name);
		$result   = $Customer->getReseller();
		$this->assertInstanceOf($result, 'MailRoute\\API\\Entity\\Reseller');
		$this->assertEquals($result->getName(), $reseller_name);
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testCustomerGetBrandingInfo()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer = $Reseller->createCustomer('customer'.$reseller_name);
		$result   = $Customer->getBrandingInfo();
		$this->assertInstanceOf($result, 'MailRoute\\API\\Entity\\Brandinginfo');
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testCustomerGetContacts()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer = $Reseller->createCustomer('customer'.$reseller_name);
		$Customer->createContact('c1@example.com');
		$Customer->createContact('c2@example.com');
		$result = $Customer->getContacts();
		$this->assertIsArray($result);
		$this->assertIsObject($result[0]);
		$this->assertEquals($result[1]->getEmail(), 'c2@example.com');
		$this->assertTrue($result[0]->delete());
		$this->assertTrue($result[1]->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testCustomerGetDomains()
	{
		$x             = mt_rand(1, 9999);
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer = $Reseller->createCustomer('customer'.$reseller_name);
		$Customer->createDomain($x.'example.com');
		$Customer->createDomain($x.'example1.com');
		$result = $Customer->getDomains();
		$this->assertIsArray($result);
		$this->assertIsObject($result[0]);
		$this->assertEquals($result[1]->getName(), $x.'example1.com');
		$this->assertTrue($result[0]->delete());
		$this->assertTrue($result[1]->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testDomainGetCustomer()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain   = $Customer->createDomain(mt_rand(1, 9999).'example.com');
		$result   = $Domain->getCustomer();
		$this->assertInstanceOf($result, get_class($Customer));
		$this->assertEquals($result->getName(), $Customer->getName());
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testDomainGetDomainAliases()
	{
		$x             = mt_rand(1, 9999);
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain   = $Customer->createDomain($x.'example.com');
		$Domain->createAlias($x.'alias1example.com');
		$Domain->createAlias($x.'alias2example.com');
		$result = $Domain->getDomainAliases();
		$this->assertInstanceOf($result[0], 'MailRoute\\API\\Entity\\DomainAlias');
		$this->assertEquals($result[1]->getName(), $x.'alias2example.com');
		foreach ($result as $Alias)
		{
			$this->assertTrue($Alias->delete());
		}
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testDomainGetEmailAccounts()
	{
		$x             = mt_rand(1, 9999);
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain   = $Customer->createDomain($x.'example.com');
		$Domain->createEmailAccount($x.'lc');
		$Domain->createEmailAccount($x.'lc2');
		$result = $Domain->getEmailAccounts();
		$this->assertInstanceOf($result[0], 'MailRoute\\API\\Entity\\EmailAccount');
		$this->assertEquals($result[1]->getLocalpart(), $x.'lc2');
		foreach ($result as $EmailAccount)
		{
			$this->assertTrue($EmailAccount->delete());
		}
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testDomainGetMailServers()
	{
		$x             = mt_rand(1, 9999);
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller    = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer    = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain      = $Customer->createDomain($x.'example.com');
		$MailServer1 = $Domain->createMailServer($x.'mail1.example.com');
		$MailServer2 = $Domain->createMailServer($x.'mail2.example.com');
		$result      = $Domain->getMailServers();
		$this->assertEquals(get_class($result[0]), get_class($MailServer1));
		$this->assertEquals($result[1]->getServer(), $MailServer2->getServer());
		$this->assertTrue($MailServer1->delete());
		$this->assertTrue($MailServer2->delete());
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testDomainGetOutBoundServers()
	{
		$x             = mt_rand(1, 9999);
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller        = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer        = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain          = $Customer->createDomain($x.'example.com');
		$OutBoundServer1 = $Domain->createOutboundServer('127.0.0.1');
		$OutBoundServer2 = $Domain->createOutboundServer('127.0.0.2');
		$result          = $Domain->getOutboundServers();
		$this->assertEquals(get_class($result[0]), get_class($OutBoundServer1));
		$this->assertEquals($result[1]->getServer(), $OutBoundServer2->getServer());
		$this->assertTrue($OutBoundServer1->delete());
		$this->assertTrue($OutBoundServer2->delete());
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testDomainGetContacts()
	{
		$x             = mt_rand(1, 9999);
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain   = $Customer->createDomain($x.'example.com');
		$Contact1 = $Domain->createContact($x.'contact1@example.com');
		$Contact2 = $Domain->createContact($x.'contact2@example.com');
		$result   = $Domain->getContacts();
		$this->assertEquals(get_class($result[0]), get_class($Contact1));
		$this->assertEquals($result[1]->getEmail(), $Contact2->getEmail());
		$this->assertTrue($Contact1->delete());
		$this->assertTrue($Contact2->delete());
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testDomainGetBlackList()
	{
		$x             = mt_rand(1, 9999);
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller   = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer   = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain     = $Customer->createDomain($x.'example.com');
		$BlackList1 = $Domain->addToBlackList($x.'contact1@example.com');
		$BlackList2 = $Domain->addToBlackList($x.'contact2@example.com');
		$WhiteList  = $Domain->addToWhiteList($x.'contact3@example.com');
		$result     = $Domain->getBlackList();
		$this->assertEquals(get_class($result[0]), get_class($BlackList1));
		$this->assertEquals($result[1]->getEmail(), $BlackList2->getEmail());
		$this->assertEquals($result[1]->getWb(), 'b');
		$this->assertEquals(count($result), 2);
		$this->assertTrue($WhiteList->delete());
		foreach ($result as $entity)
		{
			$this->assertTrue($entity->delete());
		}
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testDomainGetWhiteList()
	{
		$x             = mt_rand(1, 9999);
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller   = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer   = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain     = $Customer->createDomain($x.'example.com');
		$WhiteList1 = $Domain->addToWhiteList($x.'contact1@example.com');
		$WhiteList2 = $Domain->addToWhiteList($x.'contact2@example.com');
		$BlackList  = $Domain->addToBlackList($x.'contact3@example.com');
		$result     = $Domain->getWhiteList();
		$this->assertEquals(get_class($result[0]), get_class($WhiteList1));
		$this->assertEquals($result[1]->getEmail(), $WhiteList2->getEmail());
		$this->assertEquals($result[1]->getWb(), 'w');
		$this->assertEquals(count($result), 2);
		$this->assertTrue($BlackList->delete());
		foreach ($result as $entity)
		{
			$this->assertTrue($entity->delete());
		}
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testDomainGetPolicy()
	{
		$x             = mt_rand(1, 9999);
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain   = $Customer->createDomain($x.'example.com');
		$result   = $Domain->getPolicy();
		$this->assertInstanceOf($result, 'MailRoute\\API\\Entity\\PolicyDomain');
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testDomainGetNotificationTask()
	{
		$x             = mt_rand(1, 9999);
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain   = $Customer->createDomain($x.'example.com');
		$result   = $Domain->getNotificationTasks();
		$this->assertIsArray($result);
		$this->assertInstanceOf($result[0], 'MailRoute\\API\\Entity\\NotificationDomainTask');
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testDomainAliasGetDomain()
	{
		$x             = mt_rand(1, 9999);
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain   = $Customer->createDomain($x.'example.com');
		$Alias    = $Domain->createAlias($x.'alias.example.com');
		$result   = $Alias->getDomain();
		$this->assertInstanceOf($result, get_class($Domain));
		$this->assertEquals($result->getName(), $x.'example.com');
		$this->assertTrue($Alias->delete());
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testEmailAccountGetBlackList()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller     = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer     = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain       = $Customer->createDomain('domain'.md5(microtime(1).mt_rand(1, 9999).__LINE__).'.name');
		$localpart    = substr(md5(microtime(1).mt_rand(1, 9999).__LINE__), 5);
		$EmailAccount = $Domain->createEmailAccount($localpart);
		$EmailAccount->addToBlackList('bl1@example.com');
		$EmailAccount->addToBlackList('bl2@example.com');
		$result = $EmailAccount->getBlackList();
		$this->assertIsArray($result);
		$this->assertEquals(count($result), 2);
		$this->assertIsObject($result[0]);
		$this->assertEquals($result[1]->getEmail(), 'bl2@example.com');
		$this->assertEquals($result[1]->getWb(), 'b');
		foreach ($result as $entity)
		{
			$this->assertTrue($entity->delete());
		}
		$this->assertTrue($EmailAccount->delete());
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testContactResellerGetReseller()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Contact  = $Reseller->createContact('c@example.com');
		$result   = $Contact->getReseller();
		$this->assertEquals($result->getResourceUri(), $Reseller->getResourceUri());
		$this->assertTrue($Contact->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testContactCustomerGetCustomer()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer = $Reseller->createCustomer('customer'.$reseller_name);
		$Contact  = $Customer->createContact('x@example.com');
		$result   = $Contact->getCustomer();
		$this->assertEquals($result->getResourceUri(), $Customer->getResourceUri());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testEmailAccountAddNotificationTask()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller          = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer          = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain            = $Customer->createDomain('domain'.md5(microtime(1).mt_rand(1, 9999).__LINE__).'.name');
		$localpart         = substr(md5(microtime(1).mt_rand(1, 9999).__LINE__), 5);
		$EmailAccount      = $Domain->createEmailAccount($localpart);
		$Timezone          = new \DateTimeZone('Europe/London');
		$NotificationTask1 = $EmailAccount->addNotificationTask($Timezone, array('tue'));
		$NotificationTask2 = $EmailAccount->addNotificationTask($Timezone, array('wed'));
		$this->assertIsObject($NotificationTask1);
		$result = $EmailAccount->getNotificationTasks();
		print_r($result);
		$this->assertIsArray($result);
		$this->assertIsObject($result[0]);
		$this->assertEquals($result[0]->getResourceUri(), $NotificationTask1->getResourceUri());
		//$this->assertEquals($result[1]->getEmailAccount()->getResourceUri(), $EmailAccount->getResourceUri());
		foreach ($result as $entity)
		{
			$this->assertTrue($entity->delete());
		}
		$this->assertTrue($EmailAccount->delete());
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}

	public function testDomainAddNotificationTask()
	{
		$reseller_name = 'test '.microtime(1).mt_rand(1, 9999).__FUNCTION__;
		/** @var Reseller $Reseller */
		$Reseller          = $this->Client->API()->Reseller()->create(array('name' => $reseller_name));
		$Customer          = $Reseller->createCustomer('customer'.$reseller_name);
		$Domain            = $Customer->createDomain('domain'.md5(microtime(1).mt_rand(1, 9999).__LINE__).'.name');
		$Timezone          = new \DateTimeZone('Europe/London');
		$NotificationTask1 = $Domain->addNotificationTask($Timezone, array('tue'));
		$NotificationTask2 = $Domain->addNotificationTask($Timezone, array('tue'));
		$this->assertIsObject($NotificationTask1);
		$result = $Domain->getNotificationTasks();
		$this->assertIsArray($result);
		$this->assertIsObject($result[0]);
		$this->assertEquals($result[0]->getResourceUri(), $NotificationTask1->getResourceUri());
		$this->assertEquals($result[1]->getDomain()->getResourceUri(), $Domain->getResourceUri());
		foreach ($result as $entity)
		{
			$this->assertTrue($entity->delete());
		}
		$this->assertTrue($Domain->delete());
		$this->assertTrue($Customer->delete());
		$this->assertTrue($Reseller->delete());
	}
}
