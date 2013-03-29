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
	private $EntityConverter;
	private $api_path_prefix;
	private $delete_not_found_is_error = false;

	public function __construct(Config $Config)
	{
		$this->setAuthorizationHeader($Config->auth_method.' '.$Config->login.':'.$Config->password);
		$this->setAPIUrl($Config->schema.'://'.$Config->host.$Config->absolute_path_prefix);
		$this->setAPIPathPrefix($Config->absolute_path_prefix);
	}

	/**
	 * @param string $api_url
	 */
	public function setAPIUrl($api_url)
	{
		$this->api_url = rtrim(trim($api_url), '/').'/';
	}

	public function setAPIPathPrefix($api_path_prefix)
	{
		$this->api_path_prefix = $api_path_prefix;
	}

	/** @return API */
	public function API()
	{
		return $this;
	}

	public function __call($entity, $arguments)
	{
		return $this->getResourceHandler($entity);
	}

	protected function getResourceHandler($entity)
	{
		$entity  = strtolower($entity);
		$Handler = new ResourceHandler($this, $entity);
		return $Handler;
	}

	public function getAsyncMode()
	{
		return $this->async_mode;
	}

	public function setAsyncMode($mode = true)
	{
		$this->async_mode = $mode;
	}

	public function getEntityConverter()
	{
		if (empty($this->EntityConverter))
		{
			$this->EntityConverter = new EntityConverter();
		}
		return $this->EntityConverter;
	}

	public function getAPIPathPrefix()
	{
		return $this->api_path_prefix;
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

	public function getAuthorizationHeader()
	{
		return $this->authorization_header;
	}

	public function setAuthorizationHeader($authorization_header)
	{
		$this->authorization_header = $authorization_header;
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

	public function callAPI($url_request_part, $method, $arguments = array())
	{
		$Response = $this->SendAPIQuery($url_request_part, $method, $arguments);
		if (!is_object($Response))
		{
			if (is_bool($Response))
			{
				return $Response;
			}
			throw new Exception('Can not get response', 500);
		}
		/** @var IResponse $Response */
		if ($Response->isStatusError())
		{
			$exception_response = NULL;
			if ($message = $Response->getBody())
			{
				if (is_array($message))
				{
					$exception_response = $message;
					$message            = current($message);
				}
				if (is_array($message))
				{
					$message = print_r($message, 1);
				}
			}
			else
			{
				$message = 'Error';
			}
			if ($Response->getStatusCode() < 500)
			{
				throw new Exception($message, $Response->getStatusCode(), $exception_response);
			}
			else
			{
				throw new ValidationException($message, $Response->getStatusCode(), $exception_response);
			}
		}
		return $Response->getBody();
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
				if (count($arguments)==1 && key($arguments)===0)
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
			if ($Request->getMethod()==='DELETE')
			{
				if ($this->Response->getStatusCode()==404 && !$this->delete_not_found_is_error)
				{
					$result = true;
				}
				elseif ($this->Response->getStatusCode() < 300)
				{
					$result = true;
				}
			}
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

	protected function getNewRequest()
	{
		return new Request();
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

	protected function getNewResponse()
	{
		return new Response();
	}

	protected function getNewSerializer()
	{
		return new SerializerJSON();
	}

	public function setDeleteNotFoundIsError($delete_not_found_is_error = false)
	{
		$this->delete_not_found_is_error = $delete_not_found_is_error;
	}

	protected function getResponse()
	{
		return $this->Response;
	}
}
