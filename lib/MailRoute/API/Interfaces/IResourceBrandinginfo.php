<?php
namespace MailRoute\API\Interfaces;

use MailRoute\API\Entity\Brandinginfo;

interface IResourceBrandinginfo
{
	/**
	 * @param string $id
	 * @return Brandinginfo|Brandinginfo[]
	 */
	public function get($id = '');

	/**
	 * @param array|object $data
	 * @return Brandinginfo
	 */
	public function create($data);

	/**
	 * @param array|object $data
	 * @return Brandinginfo
	 */
	public function update($data);

	/**
	 * @param int|string $id
	 * @return boolean
	 */
	public function delete($id);

	/**
	 * @param int $limit
	 * @return IResourceBrandinginfo
	 */
	public function limit($limit);

	/**
	 * @param int $offset
	 * @return IResourceBrandinginfo
	 */
	public function offset($offset);

	/**
	 * @param array $filter_map
	 * @return IResourceBrandinginfo
	 */
	public function filter(array $filter_map);

	/** @return Brandinginfo[] */
	public function fetchList();

	/**
	 * @param string $word
	 * @return Brandinginfo[]
	 */
	public function search($word);

	/**
	 * @param array $data
	 * @return Brandinginfo[]
	 */
	public function bulkCreate($data);
}
