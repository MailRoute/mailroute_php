<?php
namespace MailRoute\API\Interfaces;

use MailRoute\API\Entity\DomainWithAlias;

interface IResourceDomainWithAlias
{
	/**
	 * @param string $id
	 * @return DomainWithAlias|DomainWithAlias[]
	 */
	public function get($id = '');

	/**
	 * @param array|object $data
	 * @return DomainWithAlias
	 */
	public function create($data);

	/**
	 * @param array|object $data
	 * @return DomainWithAlias
	 */
	public function update($data);

	/**
	 * @param int|string $id
	 * @return boolean
	 */
	public function delete($id);

	/**
	 * @param int $limit
	 * @return IResourceDomainWithAlias
	 */
	public function limit($limit);

	/**
	 * @param int $offset
	 * @return IResourceDomainWithAlias
	 */
	public function offset($offset);

	/**
	 * @param array $filter_map
	 * @return IResourceDomainWithAlias
	 */
	public function filter(array $filter_map);

	/** @return DomainWithAlias[] */
	public function fetchList();

	/**
	 * @param string $word
	 * @return DomainWithAlias[]
	 */
	public function search($word);

	/**
	 * @param array $data
	 * @return DomainWithAlias[]
	 */
	public function bulkCreate($data);
}
