<?php
namespace MailRoute\API;

interface IEntity
{
	/** @return array */
	public function get($id = '');

	/** @return array */
	public function create(array $data);

	/** @return array */
	public function update(array $data);

	/** @return boolean */
	public function delete($id);

	/** @return IEntity */
	public function limit($limit);

	/** @return IEntity */
	public function offset($offset);

	/** @return IEntity */
	public function filter(array $filter_map);

	/** @return array */
	public function fetchList();
}
