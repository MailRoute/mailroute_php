<?php
namespace MailRoute\API\Interfaces;

use MailRoute\API\Entity\Reseller;

interface IResourceReseller
{
	/**
	 * @param string $id
	 * @return Reseller|Reseller[]
	 */
	public function get($id = '');

	/**
	 * @param array|object $data
	 * @return Reseller
	 */
	public function create($data);

	/**
	 * @param array|object $data
	 * @return Reseller
	 */
	public function update($data);

	/**
	 * @param int|string $id
	 * @return boolean
	 */
	public function delete($id);

	/**
	 * @param int $limit
	 * @return IResourceReseller
	 */
	public function limit($limit);

	/**
	 * @param int $offset
	 * @return IResourceReseller
	 */
	public function offset($offset);

	/**
	 * @param array $filter_map
	 * @return IResourceReseller
	 */
	public function filter(array $filter_map);

	/** @return Reseller[] */
	public function fetchList();

	/**
	 * @param string $word
	 * @return Reseller[]
	 */
	public function search($word);

	/**
	 * @param array $data
	 * @return Reseller[]
	 */
	public function bulkCreate($data);
}
