<?php
namespace MailRoute\API;

interface IResource
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
	 * @return IResource
	 */
	public function limit($limit);

	/**
	 * @param int $offset
	 * @return IResource
	 */
	public function offset($offset);

	/**
	 * @param array $filter_map
	 * @return IResource
	 */
	public function filter(array $filter_map);

	/** @return IActiveEntity[] */
	public function fetchList();

	/**
	 * @param string $word
	 * @return IActiveEntity[]
	 */
	public function search($word);
}
