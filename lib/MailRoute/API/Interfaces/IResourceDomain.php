<?php
namespace MailRoute\API\Interfaces;

use MailRoute\API\Entity\Domain;

interface IResourceDomain
{
	/**
	 * @param string $id
	 * @return Domain|Domain[]
	 */
	public function get($id = '');

	/**
	 * @param array|object $data
	 * @return Domain
	 */
	public function create($data);

	/**
	 * @param array|object $data
	 * @return Domain
	 */
	public function update($data);

	/**
	 * @param int|string $id
	 * @return boolean
	 */
	public function delete($id);

	/**
	 * @param int $limit
	 * @return IResourceDomain
	 */
	public function limit($limit);

	/**
	 * @param int $offset
	 * @return IResourceDomain
	 */
	public function offset($offset);

	/**
	 * @param array $filter_map
	 * @return IResourceDomain
	 */
	public function filter(array $filter_map);

	/** @return Domain[] */
	public function fetchList();

	/**
	 * @param string $word
	 * @return Domain[]
	 */
	public function search($word);

	/**
	 * @param array $data
	 * @return Domain[]
	 */
	public function bulkCreate($data);
}
