<?php
namespace MailRoute\API;

use Jamm\HTTP\Connection;
use Jamm\HTTP\IRequest;
use Jamm\HTTP\IResponse;
use Jamm\HTTP\Request;
use Jamm\HTTP\Response;
use Jamm\HTTP\SerializerJSON;

class Client implements IClient
{
	private $api_url;
	private $authorization_header = '';
	/** @var IResponse */
	private $Response;
	private $custom_request_headers;
	/** @var Connection */
	private $Connection;
	private $async_mode = false;

	public function __construct(Config $Config)
	{
		$this->setAuthorizationHeader($Config->auth_method.' '.$Config->login.':'.$Config->password);
		$this->setAPIUrl($Config->schema.'://'.$Config->host.$Config->absolute_path_prefix);
	}

	/** @return API */
	public function API()
	{
		return $this;
	}

	public function __call($entity, $arguments)
	{
		return $this->getEntityHandler($entity);
	}

	protected function getEntityHandler($entity)
	{
		$entity  = strtolower($entity);
		$Handler = new EntityHandler($this);
		$Handler->setEntityName($entity);
		return $Handler;
	}

	/**
	 * @param $url_request_part
	 * @param $method
	 * @param $arguments
	 * @return IResponse
	 */
	private function SendAPIQuery($url_request_part, $method, $arguments)
	{
		$url = rtrim($this->api_url, '/').'/'.ltrim(str_replace('//', '/', $url_request_part), '/');
		if (substr($url, -1)!='/')
		{
			$url .= '/';
		}
		$Request = $this->getNewRequest();
		$Request->setMethod($method);
		if (!empty($arguments))
		{
			if (!in_array($method, array('GET', 'HEAD', 'OPTIONS')))
			{
				if (count($arguments)==1)
				{
					$arguments = current($arguments);
				}
				$arguments = json_encode($arguments);
			}
			$Request->setData($arguments);
		}
		$Request->setHeader('Authorization', $this->authorization_header);
		$Request->SetAccept('application/json');
		$Request->setHeader('Content-Type', 'application/json');
		$this->setCustomRequestHeaders($Request);
		$Request->setResponseTimeout(10);
		if (!$this->async_mode)
		{
			$Request->setHeader('Connection', 'Keep-Alive');
			if (!empty($this->Connection) && $this->Connection->isKeepAlive())
			{
				$Request->setConnection($this->Connection);
			}
			$this->Response = $this->getNewResponse();
			$Serializer     = $this->getNewSerializer();
			$this->Response->setSerializer($Serializer);
			$Request->Send($url, $this->Response);
			$result = $this->Response;
		}
		else
		{
			$Request->setHeader('Connection', 'Close');
			$Request->Send($url);
			$result = true;
		}
		$this->Connection = $Request->getConnection();
		return $result;
	}

	public function setAsyncMode($mode = true)
	{
		$this->async_mode = $mode;
	}

	/** @param string $api_url */
	public function setAPIUrl($api_url)
	{
		$this->api_url = rtrim(trim($api_url), '/').'/';
	}

	public function setAuthorizationHeader($authorization_header)
	{
		$this->authorization_header = $authorization_header;
	}

	public function callAPI($url_request_part, $method, $arguments = array())
	{
		$Response = $this->SendAPIQuery($url_request_part, $method, $arguments);
		if (!is_object($Response))
		{
			if (is_bool($Response))
			{
				return $Response;
			}
			trigger_error('Can not get response', E_USER_WARNING);
			return false;
		}
		/** @var IResponse $Response */
		if ($Response->isStatusError())
		{
			if ($message = $Response->getBody())
			{
				if (is_array($message))
				{
					$message = current($message);
				}
				if (is_array($message))
				{
					$message = print_r($message, 1);
				}
				trigger_error($message, E_USER_WARNING);
			}
			return false;
		}
		return $Response->getBody();
	}

	public function getAsyncMode()
	{
		return $this->async_mode;
	}

	protected function getResponse()
	{
		return $this->Response;
	}

	public function getApiUrl()
	{
		return $this->api_url;
	}

	/**
	 * @param string $header
	 * @param string $value
	 * @return bool
	 */
	public function setRequestHeader($header, $value)
	{
		if (empty($header)) return false;
		if ($value===NULL)
		{
			unset($this->custom_request_headers[$header]);
			return true;
		}
		$this->custom_request_headers[(string)$header] = (string)$value;
		return true;
	}

	protected function setCustomRequestHeaders(IRequest $Request)
	{
		if (empty($this->custom_request_headers)) return false;
		foreach ($this->custom_request_headers as $header => $value)
		{
			$Request->setHeader($header, $value);
		}
		return true;
	}

	public function getAuthorizationHeader()
	{
		return $this->authorization_header;
	}

	/**
	 * @return Connection
	 */
	public function getConnection()
	{
		return $this->Connection;
	}

	/**
	 * @param Connection $Connection
	 */
	public function setConnection($Connection)
	{
		$this->Connection = $Connection;
	}

	public function GET($id = '')
	{
		if (!empty($id))
		{
			return $this->callAPI('/'.$id, 'GET');
		}
		else
		{
			return $this->callAPI('', 'GET');
		}
	}

	protected function getNewRequest()
	{
		return new Request();
	}

	protected function getNewResponse()
	{
		return new Response();
	}

	protected function getNewSerializer()
	{
		return new SerializerJSON();
	}
}