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
