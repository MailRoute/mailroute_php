<?php
namespace MailRoute\API\Interfaces;

use MailRoute\API\Entity\ContactEmailAccount;

interface IResourceContactEmailAccount
{
	/**
	 * @param string $id
	 * @return ContactEmailAccount|ContactEmailAccount[]
	 */
	public function get($id = '');

	/**
	 * @param array|object $data
	 * @return ContactEmailAccount
	 */
	public function create($data);

	/**
	 * @param array|object $data
	 * @return ContactEmailAccount
	 */
	public function update($data);

	/**
	 * @param int|string $id
	 * @return boolean
	 */
	public function delete($id);

	/**
	 * @param int $limit
	 * @return IResourceContactEmailAccount
	 */
	public function limit($limit);

	/**
	 * @param int $offset
	 * @return IResourceContactEmailAccount
	 */
	public function offset($offset);

	/**
	 * @param array $filter_map
	 * @return IResourceContactEmailAccount
	 */
	public function filter(array $filter_map);

	/** @return ContactEmailAccount[] */
	public function fetchList();

	/**
	 * @param string $word
	 * @return ContactEmailAccount[]
	 */
	public function search($word);

	/**
	 * @param array $data
	 * @return ContactEmailAccount[]
	 */
	public function bulkCreate($data);
}
