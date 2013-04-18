<?php
namespace MailRoute\API\Interfaces;

use MailRoute\API\Entity\PolicyUser;

interface IResourcePolicyUser
{
	/**
	 * @param string $id
	 * @return PolicyUser|PolicyUser[]
	 */
	public function get($id = '');

	/**
	 * @param array|object $data
	 * @return PolicyUser
	 */
	public function create($data);

	/**
	 * @param array|object $data
	 * @return PolicyUser
	 */
	public function update($data);

	/**
	 * @param int|string $id
	 * @return boolean
	 */
	public function delete($id);

	/**
	 * @param int $limit
	 * @return IResourcePolicyUser
	 */
	public function limit($limit);

	/**
	 * @param int $offset
	 * @return IResourcePolicyUser
	 */
	public function offset($offset);

	/**
	 * @param array $filter_map
	 * @return IResourcePolicyUser
	 */
	public function filter(array $filter_map);

	/** @return PolicyUser[] */
	public function fetchList();

	/**
	 * @param string $word
	 * @return PolicyUser[]
	 */
	public function search($word);

	/**
	 * @param array $data
	 * @return PolicyUser[]
	 */
	public function bulkCreate($data);
}
