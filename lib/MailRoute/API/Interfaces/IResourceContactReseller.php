<?php
namespace MailRoute\API\Interfaces;

use MailRoute\API\Entity\ContactReseller;

interface IResourceContactReseller
{
	/**
	 * @param string $id
	 * @return ContactReseller|ContactReseller[]
	 */
	public function get($id = '');

	/**
	 * @param array|object $data
	 * @return ContactReseller
	 */
	public function create($data);

	/**
	 * @param array|object $data
	 * @return ContactReseller
	 */
	public function update($data);

	/**
	 * @param int|string $id
	 * @return boolean
	 */
	public function delete($id);

	/**
	 * @param int $limit
	 * @return IResourceContactReseller
	 */
	public function limit($limit);

	/**
	 * @param int $offset
	 * @return IResourceContactReseller
	 */
	public function offset($offset);

	/**
	 * @param array $filter_map
	 * @return IResourceContactReseller
	 */
	public function filter(array $filter_map);

	/** @return ContactReseller[] */
	public function fetchList();

	/**
	 * @param string $word
	 * @return ContactReseller[]
	 */
	public function search($word);

	/**
	 * @param array $data
	 * @return ContactReseller[]
	 */
	public function bulkCreate($data);
}
