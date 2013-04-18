<?php
namespace MailRoute\API\Interfaces;

use MailRoute\API\Entity\Admins;

interface IResourceAdmins
{
	/**
	 * @param string $id
	 * @return Admins|Admins[]
	 */
	public function get($id = '');

	/**
	 * @param array|object $data
	 * @return Admins
	 */
	public function create($data);

	/**
	 * @param array|object $data
	 * @return Admins
	 */
	public function update($data);

	/**
	 * @param int|string $id
	 * @return boolean
	 */
	public function delete($id);

	/**
	 * @param int $limit
	 * @return IResourceAdmins
	 */
	public function limit($limit);

	/**
	 * @param int $offset
	 * @return IResourceAdmins
	 */
	public function offset($offset);

	/**
	 * @param array $filter_map
	 * @return IResourceAdmins
	 */
	public function filter(array $filter_map);

	/** @return Admins[] */
	public function fetchList();

	/**
	 * @param string $word
	 * @return Admins[]
	 */
	public function search($word);

	/**
	 * @param array $data
	 * @return Admins[]
	 */
	public function bulkCreate($data);
}
