<?php
namespace MailRoute\API;

interface IClient
{
	/** @return API */
	public function API();

	public function GET($id = '');

	public function callAPI($url_request_part, $method, $arguments = array());

	public function getAPIPathPrefix();

	public function setAPIPathPrefix($api_path_prefix);

	public function setDeleteNotFoundIsError($delete_not_found_is_error = false);
}
