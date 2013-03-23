<?php
namespace MailRoute\API;

class EntityHandler implements IEntity
{
	private $entity_name;
	private $Client;
	private $filter = array();
	private $EntityConverter;
	private $entities_namespace;

	public function __construct(IClient $Client, $entity_name)
	{
		$this->Client      = $Client;
		$this->entity_name = $entity_name;
		$this->setEntitiesNamespace(__NAMESPACE__.'\\Entity');
	}

	public function callAPI($method, $add_to_query_path, $arguments = array())
	{
		$url_request_part = '/'.$this->entity_name.'/'.$add_to_query_path;
		$result           = $this->Client->callAPI($url_request_part, $method, $arguments);
		$result           = $this->handleAPIResponse($method, $result);
		return $result;
	}

	/**
	 * @param $method
	 * @param $result
	 * @return mixed
	 */
	protected function handleAPIResponse($method, $result)
	{
		if ($method=='GET' && isset($result['meta']) && isset($result['objects']))
		{
			$result = $result['objects'];
			return $result;
		}
		elseif ($method=='DELETE')
		{
			if ($result!==false)
			{
				$result = true;
			}
		}
		return $result;
	}

	public function setEntityName($entity_name)
	{
		$this->entity_name = $entity_name;
	}

	public function get($id = '')
	{
		$result = $this->callAPI('GET', $id);
		if (is_array($result))
		{
			if (key($result)===0 && is_array(current($result)))
			{
				$objects = array();
				foreach ($result as $data)
				{
					$objects[] = $this->getActiveEntityFromArray($data);
				}
				return $objects;
			}
			else
			{
				return $this->getActiveEntityFromArray($result);
			}
		}
		return $result;
	}

	public function create($data)
	{
		if (is_object($data))
		{
			if (is_a($data, 'MailRoute\\API\\IActiveEntity'))
			{
				$data = $data->getEntity();
			}
			$data = $this->getEntityConverter()->mapObjectToArray($data);
		}
		$result = $this->callAPI('POST', '', $data);
		$Entity = $this->getActiveEntityFromArray($result);
		return $Entity;
	}

	public function update($data)
	{
		if (is_object($data))
		{
			if (is_a($data, 'MailRoute\\API\\IActiveEntity'))
			{
				$data = $data->getEntity();
			}
			$data = $this->getEntityConverter()->mapObjectToArray($data);
		}
		$add = '';
		if (isset($data['id']))
		{
			$id = $data['id'];
			if (!empty($id))
			{
				$add = $id.'/';
			}
		}
		$result = $this->callAPI('PUT', $add, $data);
		$Entity = $this->getActiveEntityFromArray($result);
		return $Entity;
	}

	public function delete($id)
	{
		try
		{
			$this->callAPI('DELETE', $id);
		}
		catch (MailRouteException $E)
		{
			if ($E->getCode()<>404)
			{
				throw $E;
			}
		}
		return true;
	}

	public function limit($limit)
	{
		$this->filter['limit'] = $limit;
		return $this;
	}

	public function offset($offset)
	{
		$this->filter['offset'] = $offset;
		return $this;
	}

	public function filter(array $filter_map)
	{
		$this->filter = array_merge($this->filter, $filter_map);
		return $this;
	}

	public function fetchList()
	{
		$result = $this->callAPI('GET', '', $this->filter);
		if (is_array($result))
		{
			$objects = array();
			foreach ($result as $data)
			{
				$objects[] = $this->getActiveEntityFromArray($data);
			}
			return $objects;
		}
		return $result;
	}

	protected function getEntityConverter()
	{
		if (empty($this->EntityConverter))
		{
			$this->EntityConverter = new EntityConverter();
		}
		return $this->EntityConverter;
	}

	protected function getActiveEntityFromArray(array $data)
	{
		$class  = $this->getEntitiesNamespace().'\\'.$this->inCamelCase($this->entity_name);
		$Entity = new $class;
		$this->getEntityConverter()->mapObjectFromArray($Entity, $data);
		return $this->getActiveEntity($Entity);
	}

	protected function getActiveEntity($Entity)
	{
		return new ActiveEntity($Entity, $this);
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

	public function getEntitiesNamespace()
	{
		return $this->entities_namespace;
	}

	public function setEntitiesNamespace($entities_namespace)
	{
		$this->entities_namespace = $entities_namespace;
	}
}
