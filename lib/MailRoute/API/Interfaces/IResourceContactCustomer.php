<?php
namespace MailRoute\API\Interfaces;

use MailRoute\API\Entity\ContactCustomer;

interface IResourceContactCustomer
{
	/**
	 * @param string $id
	 * @return ContactCustomer|ContactCustomer[]
	 */
	public function get($id = '');

	/**
	 * @param array|object $data
	 * @return ContactCustomer
	 */
	public function create($data);

	/**
	 * @param array|object $data
	 * @return ContactCustomer
	 */
	public function update($data);

	/**
	 * @param int|string $id
	 * @return boolean
	 */
	public function delete($id);

	/**
	 * @param int $limit
	 * @return IResourceContactCustomer
	 */
	public function limit($limit);

	/**
	 * @param int $offset
	 * @return IResourceContactCustomer
	 */
	public function offset($offset);

	/**
	 * @param array $filter_map
	 * @return IResourceContactCustomer
	 */
	public function filter(array $filter_map);

	/** @return ContactCustomer[] */
	public function fetchList();

	/**
	 * @param string $word
	 * @return ContactCustomer[]
	 */
	public function search($word);

	/**
	 * @param array $data
	 * @return ContactCustomer[]
	 */
	public function bulkCreate($data);
}
