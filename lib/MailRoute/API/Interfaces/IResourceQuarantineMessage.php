<?php
namespace MailRoute\API\Interfaces;

use MailRoute\API\Entity\QuarantineMessage;

interface IResourceQuarantineMessage
{
	/**
	 * @param string $id
	 * @return QuarantineMessage|QuarantineMessage[]
	 */
	public function get($id = '');

	/**
	 * @param array|object $data
	 * @return QuarantineMessage
	 */
	public function create($data);

	/**
	 * @param array|object $data
	 * @return QuarantineMessage
	 */
	public function update($data);

	/**
	 * @param int|string $id
	 * @return boolean
	 */
	public function delete($id);

	/**
	 * @param int $limit
	 * @return IResourceQuarantineMessage
	 */
	public function limit($limit);

	/**
	 * @param int $offset
	 * @return IResourceQuarantineMessage
	 */
	public function offset($offset);

	/**
	 * @param array $filter_map
	 * @return IResourceQuarantineMessage
	 */
	public function filter(array $filter_map);

	/** @return QuarantineMessage[] */
	public function fetchList();

	/**
	 * @param string $word
	 * @return QuarantineMessage[]
	 */
	public function search($word);

	/**
	 * @param array $data
	 * @return QuarantineMessage[]
	 */
	public function bulkCreate($data);
}
