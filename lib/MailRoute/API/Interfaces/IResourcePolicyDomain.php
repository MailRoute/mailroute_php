<?php
namespace MailRoute\API\Interfaces;

use MailRoute\API\Entity\PolicyDomain;

interface IResourcePolicyDomain
{
	/**
	 * @param string $id
	 * @return PolicyDomain|PolicyDomain[]
	 */
	public function get($id = '');

	/**
	 * @param array|object $data
	 * @return PolicyDomain
	 */
	public function create($data);

	/**
	 * @param array|object $data
	 * @return PolicyDomain
	 */
	public function update($data);

	/**
	 * @param int|string $id
	 * @return boolean
	 */
	public function delete($id);

	/**
	 * @param int $limit
	 * @return IResourcePolicyDomain
	 */
	public function limit($limit);

	/**
	 * @param int $offset
	 * @return IResourcePolicyDomain
	 */
	public function offset($offset);

	/**
	 * @param array $filter_map
	 * @return IResourcePolicyDomain
	 */
	public function filter(array $filter_map);

	/** @return PolicyDomain[] */
	public function fetchList();

	/**
	 * @param string $word
	 * @return PolicyDomain[]
	 */
	public function search($word);

	/**
	 * @param array $data
	 * @return PolicyDomain[]
	 */
	public function bulkCreate($data);
}
