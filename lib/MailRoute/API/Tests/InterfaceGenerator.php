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
			$code .= "\t/** @return IResource */\n";
			$code .= "\tpublic function ".$EntityConverter->inCamelCase($entity)."();\n\n";
		}
		$code .= "}\n";
		return $code;
	}
}
