<?php
namespace MailRoute\API;

class Exception extends \Exception
{
	protected $response;

	/**
	 * @param string $message
	 * @param int $code
	 * @param mixed $response
	 */
	public function __construct($message = '', $code = 0, $response = NULL)
	{
		parent::__construct($message, $code);
		$this->response = $response;
	}

	public function getResponse()
	{
		return $this->response;
	}

	public function setResponse($response)
	{
		$this->response = $response;
	}
}
