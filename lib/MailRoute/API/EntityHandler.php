<?php
namespace MailRoute\API;

class EntityHandler implements IEntity
{
	private $entity_name;
	private $Client;
	private $filter = array();

	public function __construct(IClient $Client, $entity_name)
	{
		$this->Client      = $Client;
		$this->entity_name = $entity_name;
	}

//	public function __call($function, $arguments)
//	{
//		$method           = $function;
//		$url_request_part = '/'.$this->entity_name.'/';
//		$this->handleEntityRequest($arguments, $method, $url_request_part);
//		$result = $this->Client->callAPI($url_request_part, $method, $arguments);
//		$result = $this->handleAPIResponse($method, $result);
//		return $result;
//	}

	protected function callAPI($method, $add_to_query_path, $arguments = array())
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

	/**
	 * @param $arguments
	 * @param $method
	 * @param $url_request_part
	 */
	protected function handleEntityRequest(&$arguments, &$method, &$url_request_part)
	{
		if ($method=='GET' && !empty($arguments))
		{
			$id = array_shift($arguments);
			if (!empty($id))
			{
				$url_request_part .= $id.'/';
			}
			if (empty($arguments)) return;
			$filters = array_shift($arguments);
			if (!empty($arguments))
			{
				$offset = array_shift($arguments);
			}
			if (!empty($arguments))
			{
				$limit = array_shift($arguments);
			}
			$arguments = $filters;
			if (!empty($offset))
			{
				$arguments['offset'] = $offset;
			}
			if (!empty($limit))
			{
				$arguments['limit'] = $limit;
			}
		}
		elseif ($method=='PUT')
		{
			$id = $arguments[0]['id'];
			if (!empty($id))
			{
				$url_request_part .= $id.'/';
			}
		}
	}

	public function setEntityName($entity_name)
	{
		$this->entity_name = $entity_name;
	}

	public function get($id = '')
	{
		return $this->callAPI('GET', $id);
	}

	public function create(array $data)
	{
		return $this->callAPI('POST', '', $data);
	}

	public function update(array $data)
	{
		$add = '';
		if (isset($data['id']))
		{
			$id = $data['id'];
			if (!empty($id))
			{
				$add = $id.'/';
			}
		}
		return $this->callAPI('PUT', $add, $data);
	}

	public function delete($id)
	{
		return $this->callAPI('DELETE', $id);
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
		return $this->callAPI('GET', '', $this->filter);
	}
}
