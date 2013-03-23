<?php
namespace MailRoute\API;

interface IEntity
{
	/**
	 * @param string $id
	 * @return IActiveEntity|IActiveEntity[]
	 */
	public function get($id = '');

	/**
	 * @param array|object $data
	 * @return IActiveEntity
	 */
	public function create($data);

	/**
	 * @param array|object $data
	 * @return IActiveEntity
	 */
	public function update($data);

	/**
	 * @param int|string $id
	 * @return boolean
	 */
	public function delete($id);

	/**
	 * @param int $limit
	 * @return IEntity
	 */
	public function limit($limit);

	/**
	 * @param int $offset
	 * @return IEntity
	 */
	public function offset($offset);

	/**
	 * @param array $filter_map
	 * @return IEntity
	 */
	public function filter(array $filter_map);

	/** @return IActiveEntity[] */
	public function fetchList();
}
