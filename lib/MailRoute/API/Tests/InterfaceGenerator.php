<?php
namespace MailRoute\API\Tests;

use MailRoute\API\IClient;

class InterfaceGenerator
{
	public function getInterface(IClient $Client)
	{
		$schema   = $Client->GET();
		$entities = array_keys($schema);
		$code     = "<?php\n".
				"namespace MailRoute\\API;\n\n".
				"interface API\n".
				"{\n";
		foreach ($entities as $entity)
		{
			$code .= "\t/** @return IEntity */\n";
			$code .= "\tpublic function ".ucfirst(strtolower($entity))."();\n\n";
		}
		$code .= "}\n";
		return $code;
	}
}