MailRoute API PHP Client  
========================
[![Build Status](https://travis-ci.org/MailRoute/mailroute_php_new.png)](https://travis-ci.org/MailRoute/mailroute_php_new)    

#Requirements 
PHP 5.3+  
[Jamm\HTTP](https://github.com/jamm/HTTP)    

#Usage examples
`$Client = new \MailRoute\API\Client($Config);`  

##Create "Reseller" entity
`$Client->API()->Reseller->POST(['name'=>'New Reseller']);`   
is equal to:  
`$Client->Reseller->POST(['name'=>'New Reseller']);`    
method `API()` exists only for autocompletion (also called "IntelliSense") in IDE.  
Method POST will return an array, containing all fields of entity.

##Get Reseller by ID
`$Client->API()->Reseller->GET(99);`  
 
##Get Reseller by name
`$Client->API()->Reseller->GET(0, ['name'=>'New Reseller']);`  
