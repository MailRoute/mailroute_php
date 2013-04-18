<?php
namespace MailRoute\API\Tests;

use MailRoute\API\EntityConverter;
use MailRoute\API\IClient;

class InterfaceGenerator
{
	public function getInterface(IClient $Client)
	{
		$EntityConverter = new EntityConverter();
		$schema          = $Client->GET();
		$entities        = array_keys($schema);
		$code            = "<?php\n".
				"namespace MailRoute\\API;\n\n".
				"interface API\n".
				"{\n";
		foreach ($entities as $entity)
		{
			$entity_name = $EntityConverter->inCamelCase($entity);
			if ($entity_interface = $this->createEntityResourceInterface($entity_name))
			{
				$code .= "\t/** @return $entity_interface */\n";
			}
			else
			{
				$code .= "\t/** @return IResource */\n";
			}
			$code .= "\tpublic function ".$entity_name."();\n\n";
		}
		$code .= "}\n";
		return $code;
	}

	protected function createEntityResourceInterface($entity)
	{
		$name     = "IResource$entity";
		$code     = file_get_contents(__DIR__.'/../IResource.php');
		$code     = str_replace('namespace MailRoute\\API;',
			"namespace MailRoute\\API\\Interfaces;\n\nuse MailRoute\\API\\Entity\\$entity;", $code);
		$code     = str_replace('IActiveEntity', $entity, $code);
		$code     = str_replace('IResource', $name, $code);
		$filename = __DIR__.'/../Interfaces/'.$name.'.php';
		if (!file_exists($filename))
		{
			if (!file_put_contents($filename, $code))
			{
				return false;
			}
		}
		return 'Interfaces\\'.$name;
	}
}
