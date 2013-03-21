<?php
namespace MailRoute\API;

interface IClient
{
	/** @return API */
	public function API();
	
	public function GET($id = '');
	
	public function callAPI($url_request_part, $method, $arguments = array());
}
