<?php
namespace MailRoute\API;

class Config
{
	public $schema = 'https';
	public $host;
	public $absolute_path_prefix;
	public $auth_method;
	public $login;
	public $password;

	public function __construct($data = array())
	{
		if (!empty($data) && is_array($data))
		{
			foreach ($data as $key => $value)
			{
				if (property_exists($this, $key))
				{
					$this->$key = $value;
				}
			}
		}
	}
}
