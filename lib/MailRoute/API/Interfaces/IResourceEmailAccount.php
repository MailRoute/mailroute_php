<?php
namespace MailRoute\API\Interfaces;

use MailRoute\API\Entity\EmailAccount;

interface IResourceEmailAccount
{
	/**
	 * @param string $id
	 * @return EmailAccount|EmailAccount[]
	 */
	public function get($id = '');

	/**
	 * @param array|object $data
	 * @return EmailAccount
	 */
	public function create($data);

	/**
	 * @param array|object $data
	 * @return EmailAccount
	 */
	public function update($data);

	/**
	 * @param int|string $id
	 * @return boolean
	 */
	public function delete($id);

	/**
	 * @param int $limit
	 * @return IResourceEmailAccount
	 */
	public function limit($limit);

	/**
	 * @param int $offset
	 * @return IResourceEmailAccount
	 */
	public function offset($offset);

	/**
	 * @param array $filter_map
	 * @return IResourceEmailAccount
	 */
	public function filter(array $filter_map);

	/** @return EmailAccount[] */
	public function fetchList();

	/**
	 * @param string $word
	 * @return EmailAccount[]
	 */
	public function search($word);

	/**
	 * @param array $data
	 * @return EmailAccount[]
	 */
	public function bulkCreate($data);
}
