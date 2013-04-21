MailRoute API PHP Client  
========================
[![Build Status](https://travis-ci.org/MailRoute/mailroute_php_new.png)](https://travis-ci.org/MailRoute/mailroute_php_new)    

#Requirements 
PHP 5.3+  
[Jamm\HTTP](https://github.com/jamm/HTTP)    

#Usage examples
`$Client = new \MailRoute\API\Client($Config);`  

##Create "Reseller" entity
`$Client->API()->Reseller->create(['name'=>'New Reseller']);`   
is equal to:  
`$Client->Reseller->create(['name'=>'New Reseller']);`    
method `API()` exists only for autocompletion (also called "IntelliSense") in IDE.  
Also, you can use Reseller object entity as argument:  
`$Reseller = new Reseller();  
$Reseller->setName('New Reseller');  
$CreatedReseller = $Client->API()->Reseller->create($Reseller);`

##Get Reseller by ID
`$Reseller = $Client->API()->Reseller->get(99);`  
 
##Get list of Resellers by name
`$Reseller = $Client->API()->Reseller->filter(['name'=>'New Reseller'])->fetchList();`        

##Read list with offset and limit
`$Reseller = $Client->API()->Reseller->offset(5)->limit(30)->fetchList();`

#Resource handler
There is 2 type of objects: entities and resources.   
Each Entity has own custom methods and (common methods are declared in [IActiveEntity](lib/MailRoute/API/IActiveEntity.php) interface).    
Entity can be changed and saved to related resource by `save` method, or deleted by method `delete`, but can't create new resource.      
[Resources](lib/MailRoute/API/IResource.php) are implemented as methods of the API Client, so you can create new resources (`Client->API()->Reseller->create()`) and fetch them from API (methods `get`,`fetchList`,`search`).  
Results of these methods are Entities.      

#Additional methods 
Some entities have additional methods. All methods can be found in IDE autocompletion results, or in source code, or here.    

* Admins::regenerateApiKey()    
* Customer::createDomain()  
* Customer::createContact()  
* Customer::deleteContact()  
* Customer::createAdmin()  
* Customer::deleteAdmin()    
* Domain::moveToCustomer()      
* Domain::createContact()      
* Domain::deleteContact()      
* Domain::createMailServer()      
* Domain::createOutboundServer()      
* Domain::createEmailAccount()      
* Domain::createAlias()      
* Domain::addToBlackList()      
* Domain::addToWhiteList()      
* Domain::addNotificationTask()      
* EmailAccount::addAlias()  
* EmailAccount::bulkAddAlias()  
* EmailAccount::addNotificationTask()  
* EmailAccount::addToBlackList()  
* EmailAccount::makeAliasesFrom()  
* EmailAccount::useDomainPolicy()  
* EmailAccount::useSelfPolicy()  
* EmailAccount::regenerateApiKey()  
* EmailAccount::useDomainNotifications()  
* EmailAccount::useSelfNotifications()  
* Policy::enableSpamFiltering()  
* Policy::disableSpamFiltering()  
* Policy::enableVirusFiltering()  
* Policy::disableVirusFiltering()  
* Policy::enableBadHdrFilter()  
* Policy::disableBadHdrFilter()  
* Policy::enableBannedFilter()  
* Policy::disableBannedFilter()  
* Policy::setAntiSpamMode()  
* Reseller::createAdmin()  
* Reseller::deleteAdmin()  
* Reseller::createContact()  
* Reseller::deleteContact()  
* Reseller::createCustomer()  

