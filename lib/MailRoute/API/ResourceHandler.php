<?php
namespace MailRoute\API;

class ResourceHandler implements IResource
{
	private $entity_name;
	private $Client;
	private $filter = array();
	private $EntityConverter;
	private $entities_namespace;
	private $resource_name;

	public function __construct(IClient $Client, $entity_name)
	{
		$this->Client      = $Client;
		$this->entity_name = $entity_name;
		$this->setEntitiesNamespace(__NAMESPACE__.'\\Entity');
	}

	public function callAPI($method, $add_to_query_path, $arguments = array())
	{
		$url_request_part = '/'.$this->getResourceName().'/'.$add_to_query_path;
		$result           = $this->Client->callAPI($url_request_part, $method, $arguments);
		$result           = $this->handleAPIResponse($method, $result);
		return $result;
	}

	protected function getResourceName()
	{
		if (empty($this->resource_name))
		{
			$Entity              = $this->getActiveEntity();
			$this->resource_name = $Entity->getApiEntityResource();
		}
		return $this->resource_name;
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
					$objects[] = $this->getActiveEntity($data);
				}
				return $objects;
			}
			else
			{
				return $this->getActiveEntity($result);
			}
		}
		return $result;
	}

	public function create($data)
	{
		if (is_object($data))
		{
			$data = $this->getArrayFromInputObject($data);
		}
		$result = $this->callAPI('POST', '', $data);
		$Entity = $this->getActiveEntity($result);
		return $Entity;
	}

	public function update($data)
	{
		if (is_object($data))
		{
			$data = $this->getArrayFromInputObject($data);
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
		$Entity = $this->getActiveEntity($result);
		return $Entity;
	}

	/**
	 * @param object $data
	 * @return array
	 */
	protected function getArrayFromInputObject($data)
	{
		if (is_a($data, 'MailRoute\\API\\ActiveEntity'))
		{
			/** @var ActiveEntity $data */
			return $data->getAPIEntityFields();
		}
		else
		{
			return $this->getEntityConverter()->mapObjectToArray($data);
		}
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
				$objects[] = $this->getActiveEntity($data);
			}
			return $objects;
		}
		return $result;
	}

	public function search($word)
	{
		$result = $this->callAPI('GET', '', array('q' => $word));
		if (is_array($result))
		{
			$objects = array();
			foreach ($result as $data)
			{
				$objects[] = $this->getActiveEntity($data);
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

	protected function getActiveEntity(array $data = array())
	{
		$class = $this->getEntitiesNamespace().'\\'.$this->entity_name;
		/** @var ActiveEntity $Entity */
		$Entity = new $class($this->Client);
		if (!empty($data))
		{
			$Entity->setAPIEntityFields($data);
		}
		return $Entity;
	}

	public function getEntitiesNamespace()
	{
		return $this->entities_namespace;
	}

	public function setEntitiesNamespace($entities_namespace)
	{
		$this->entities_namespace = $entities_namespace;
	}

	public function setEntityConverter($EntityConverter)
	{
		$this->EntityConverter = $EntityConverter;
	}
}
