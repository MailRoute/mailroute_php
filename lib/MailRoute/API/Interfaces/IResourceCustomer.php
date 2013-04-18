<?php
namespace MailRoute\API\Interfaces;

use MailRoute\API\Entity\Customer;

interface IResourceCustomer
{
	/**
	 * @param string $id
	 * @return Customer|Customer[]
	 */
	public function get($id = '');

	/**
	 * @param array|object $data
	 * @return Customer
	 */
	public function create($data);

	/**
	 * @param array|object $data
	 * @return Customer
	 */
	public function update($data);

	/**
	 * @param int|string $id
	 * @return boolean
	 */
	public function delete($id);

	/**
	 * @param int $limit
	 * @return IResourceCustomer
	 */
	public function limit($limit);

	/**
	 * @param int $offset
	 * @return IResourceCustomer
	 */
	public function offset($offset);

	/**
	 * @param array $filter_map
	 * @return IResourceCustomer
	 */
	public function filter(array $filter_map);

	/** @return Customer[] */
	public function fetchList();

	/**
	 * @param string $word
	 * @return Customer[]
	 */
	public function search($word);

	/**
	 * @param array $data
	 * @return Customer[]
	 */
	public function bulkCreate($data);
}
