<?php
namespace MailRoute\API\Interfaces;

use MailRoute\API\Entity\Mailaddr;

interface IResourceMailaddr
{
	/**
	 * @param string $id
	 * @return Mailaddr|Mailaddr[]
	 */
	public function get($id = '');

	/**
	 * @param array|object $data
	 * @return Mailaddr
	 */
	public function create($data);

	/**
	 * @param array|object $data
	 * @return Mailaddr
	 */
	public function update($data);

	/**
	 * @param int|string $id
	 * @return boolean
	 */
	public function delete($id);

	/**
	 * @param int $limit
	 * @return IResourceMailaddr
	 */
	public function limit($limit);

	/**
	 * @param int $offset
	 * @return IResourceMailaddr
	 */
	public function offset($offset);

	/**
	 * @param array $filter_map
	 * @return IResourceMailaddr
	 */
	public function filter(array $filter_map);

	/** @return Mailaddr[] */
	public function fetchList();

	/**
	 * @param string $word
	 * @return Mailaddr[]
	 */
	public function search($word);

	/**
	 * @param array $data
	 * @return Mailaddr[]
	 */
	public function bulkCreate($data);
}
