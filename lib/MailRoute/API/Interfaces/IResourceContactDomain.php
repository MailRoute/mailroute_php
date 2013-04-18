<?php
namespace MailRoute\API\Interfaces;

use MailRoute\API\Entity\ContactDomain;

interface IResourceContactDomain
{
	/**
	 * @param string $id
	 * @return ContactDomain|ContactDomain[]
	 */
	public function get($id = '');

	/**
	 * @param array|object $data
	 * @return ContactDomain
	 */
	public function create($data);

	/**
	 * @param array|object $data
	 * @return ContactDomain
	 */
	public function update($data);

	/**
	 * @param int|string $id
	 * @return boolean
	 */
	public function delete($id);

	/**
	 * @param int $limit
	 * @return IResourceContactDomain
	 */
	public function limit($limit);

	/**
	 * @param int $offset
	 * @return IResourceContactDomain
	 */
	public function offset($offset);

	/**
	 * @param array $filter_map
	 * @return IResourceContactDomain
	 */
	public function filter(array $filter_map);

	/** @return ContactDomain[] */
	public function fetchList();

	/**
	 * @param string $word
	 * @return ContactDomain[]
	 */
	public function search($word);

	/**
	 * @param array $data
	 * @return ContactDomain[]
	 */
	public function bulkCreate($data);
}
