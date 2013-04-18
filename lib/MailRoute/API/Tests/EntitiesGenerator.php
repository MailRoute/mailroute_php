<?php
namespace MailRoute\API\Tests;

use MailRoute\API\IClient;

class EntitiesGenerator
{
	public function generateEntities($dir, $namespace, IClient $Client, $parent_entity = '')
	{
		$schema   = $Client->GET();
		$entities = array_keys($schema);
		foreach ($entities as $entity)
		{
			$code = $this->generateEntityCode($Client, $entity, $namespace, $parent_entity);
			if (!empty($code))
			{
				$this->writeEntityFile($dir, $entity, $code);
			}
		}
	}

	protected function generateEntityCode(IClient $Client, $entity, $namespace, $parent_entity = '')
	{
		$code = '';
		try
		{
			$schema = $Client->GET($entity.'/schema/');
		}
		catch (\Exception $E)
		{
			return false;
		}
		if (empty($schema))
		{
			return false;
		}
		$code .= "<?php\n".
				"namespace $namespace;\n\n";
		$code .= "class ".$this->inCamelCase($entity);
		if (!empty($parent_entity))
		{
			$parent_entity = '\\'.trim($parent_entity, '\\');
			$code .= " extends $parent_entity";
		}
		$code .= "\n{\n";
		$code .= "\tprotected \$api_entity_resource = '".$entity."';\n";
		if (!empty($schema['fields']))
		{
			$code .= "\tprotected \$fields = array();\n";
			$code .= "\n";
			foreach ($schema['fields'] as $field => $properties)
			{
				$code .= "\tpublic function get".$this->inCamelCase($field)."()\n".
						"\t{\n".
						"\t\treturn \$this->fields['$field'];\n".
						"\t}\n\n";
				if (!isset($properties['readonly']) || !$properties['readonly'] || $properties['readonly']==='false')
				{
					$code .= "\tpublic function set".$this->inCamelCase($field)."($$field)\n".
							"\t{\n".
							"\t\t\$this->fields['$field'] = \$$field;\n".
							"\t}\n\n";
				}
			}
		}
		$code .= "}\n";
		return $code;
	}

	protected function writeEntityFile($dir, $entity, $code)
	{
		if (empty($code))
		{
			return false;
		}
		$filename = rtrim($dir, '/').'/'.$this->inCamelCase($entity).'.php';
		if (file_exists($filename) && filesize($filename) > 1)
		{
			return false;
		}
		return file_put_contents($filename, $code);
	}

	protected function inCamelCase($string)
	{
		if (is_numeric($string[0]))
		{
			$string = 'n_'.$string;
		}
		$string = str_replace('_', ' ', $string);
		$string = ucwords(strtolower($string));
		$string = str_replace(' ', '', $string);
		return $string;
	}
}
