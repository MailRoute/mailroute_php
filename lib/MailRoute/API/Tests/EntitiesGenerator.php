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
		$code   = '';
		$schema = $Client->GET($entity.'/schema/');
		if (empty($schema))
		{
			return false;
		}
		$code .= "<?php\n".
				"namespace $namespace;\n\n".
				"class ".$this->inCamelCase($entity);
		if (!empty($parent_entity))
		{
			$code .= " extends $parent_entity";
		}
		$code .= "\n{\n";
		if (!empty($schema['fields']))
		{
			foreach ($schema['fields'] as $field => $properties)
			{
				$code .= "\tprivate $".$field.";\n";
			}
			$code .= "\n";
			foreach ($schema['fields'] as $field => $properties)
			{
				$code .= "\tpublic function get".$this->inCamelCase($field)."()\n".
						"\t{\n".
						"\t\t".'return $this->'.$field.";\n".
						"\t}\n\n";
				if (!isset($properties['readonly']) || !$properties['readonly'] || $properties['readonly']==='false')
				{
					$code .= "\tpublic function set".$this->inCamelCase($field)."($$field)\n".
							"\t{\n".
							"\t\t".'$this->'.$field.' = $'.$field.";\n".
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
		return file_put_contents(rtrim($dir, '/').'/'.$this->inCamelCase($entity).'.php', $code);
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
