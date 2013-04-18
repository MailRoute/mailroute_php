<?php
namespace MailRoute\API\Interfaces;

use MailRoute\API\Entity\Wblist;

interface IResourceWblist
{
	/**
	 * @param string $id
	 * @return Wblist|Wblist[]
	 */
	public function get($id = '');

	/**
	 * @param array|object $data
	 * @return Wblist
	 */
	public function create($data);

	/**
	 * @param array|object $data
	 * @return Wblist
	 */
	public function update($data);

	/**
	 * @param int|string $id
	 * @return boolean
	 */
	public function delete($id);

	/**
	 * @param int $limit
	 * @return IResourceWblist
	 */
	public function limit($limit);

	/**
	 * @param int $offset
	 * @return IResourceWblist
	 */
	public function offset($offset);

	/**
	 * @param array $filter_map
	 * @return IResourceWblist
	 */
	public function filter(array $filter_map);

	/** @return Wblist[] */
	public function fetchList();

	/**
	 * @param string $word
	 * @return Wblist[]
	 */
	public function search($word);

	/**
	 * @param array $data
	 * @return Wblist[]
	 */
	public function bulkCreate($data);
}
