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
Method POST will return an array, containing all fields of entity.

##Get Reseller by ID
`$Client->API()->Reseller->get(99);`  
 
##Get list of Resellers by name
`$Client->API()->Reseller->filter(['name'=>'New Reseller'])->fetchList();`        

##Read list with offset and limit
`$Client->API()->Reseller->offset(5)->limit(30)->fetchList();`    
