<?php
namespace MailRoute\API\Interfaces;

use MailRoute\API\Entity\DomainAlias;

interface IResourceDomainAlias
{
	/**
	 * @param string $id
	 * @return DomainAlias|DomainAlias[]
	 */
	public function get($id = '');

	/**
	 * @param array|object $data
	 * @return DomainAlias
	 */
	public function create($data);

	/**
	 * @param array|object $data
	 * @return DomainAlias
	 */
	public function update($data);

	/**
	 * @param int|string $id
	 * @return boolean
	 */
	public function delete($id);

	/**
	 * @param int $limit
	 * @return IResourceDomainAlias
	 */
	public function limit($limit);

	/**
	 * @param int $offset
	 * @return IResourceDomainAlias
	 */
	public function offset($offset);

	/**
	 * @param array $filter_map
	 * @return IResourceDomainAlias
	 */
	public function filter(array $filter_map);

	/** @return DomainAlias[] */
	public function fetchList();

	/**
	 * @param string $word
	 * @return DomainAlias[]
	 */
	public function search($word);

	/**
	 * @param array $data
	 * @return DomainAlias[]
	 */
	public function bulkCreate($data);
}
