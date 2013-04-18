<?php
namespace MailRoute\API\Interfaces;

use MailRoute\API\Entity\LocalpartAlias;

interface IResourceLocalpartAlias
{
	/**
	 * @param string $id
	 * @return LocalpartAlias|LocalpartAlias[]
	 */
	public function get($id = '');

	/**
	 * @param array|object $data
	 * @return LocalpartAlias
	 */
	public function create($data);

	/**
	 * @param array|object $data
	 * @return LocalpartAlias
	 */
	public function update($data);

	/**
	 * @param int|string $id
	 * @return boolean
	 */
	public function delete($id);

	/**
	 * @param int $limit
	 * @return IResourceLocalpartAlias
	 */
	public function limit($limit);

	/**
	 * @param int $offset
	 * @return IResourceLocalpartAlias
	 */
	public function offset($offset);

	/**
	 * @param array $filter_map
	 * @return IResourceLocalpartAlias
	 */
	public function filter(array $filter_map);

	/** @return LocalpartAlias[] */
	public function fetchList();

	/**
	 * @param string $word
	 * @return LocalpartAlias[]
	 */
	public function search($word);

	/**
	 * @param array $data
	 * @return LocalpartAlias[]
	 */
	public function bulkCreate($data);
}
