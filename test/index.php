<?php
include __DIR__.'/../vendors/Autoload/lib/Jamm/Autoload/Autoloader.php';
$Autoloader = new Jamm\Autoload\Autoloader(false);
$Autoloader->set_modules_dir(__DIR__.'/../vendors');
$Autoloader->register_namespace_dir('MailRoute\\API', __DIR__.'/../lib/MailRoute/API/');
$Autoloader->register_namespace_dir('Jamm\\HTTP', __DIR__.'/../vendors/HTTP/lib/Jamm/HTTP/');
$Autoloader->start();

$Config = new \MailRoute\API\Config(json_decode(file_get_contents(__DIR__.'/config.json'), true));

$Client = new \MailRoute\API\Tests\ClientMock($Config);
$Test   = new \MailRoute\API\Tests\TestClient($Client);
$Test->RunTests();
$Printer = new \Jamm\Tester\ResultsPrinter();
$Printer->addTests($Test->getTests());
$Printer->printResultsLine();
$tests = $Test->getTests();

////Generate entities
//$EG = new \MailRoute\API\Tests\EntitiesGenerator();
//$EG->generateEntities(__DIR__.'/../lib/MailRoute/API/Entity', 'MailRoute\\API\\Entity', $Client);
////Generate API interface for code completion
//$IG = new \MailRoute\API\Tests\InterfaceGenerator();
//file_put_contents(__DIR__.'/../lib/MailRoute/API/API.php', $IG->getInterface($Client));

foreach ($tests as $test_result)
{
	if (!$test_result->isSuccessful())
	{
		$Printer->printFailedTests();
		exit(1);
	}
}
exit(0);
