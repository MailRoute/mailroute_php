<?php
namespace MailRoute\API\Interfaces;

use MailRoute\API\Entity\MailServer;

interface IResourceMailServer
{
	/**
	 * @param string $id
	 * @return MailServer|MailServer[]
	 */
	public function get($id = '');

	/**
	 * @param array|object $data
	 * @return MailServer
	 */
	public function create($data);

	/**
	 * @param array|object $data
	 * @return MailServer
	 */
	public function update($data);

	/**
	 * @param int|string $id
	 * @return boolean
	 */
	public function delete($id);

	/**
	 * @param int $limit
	 * @return IResourceMailServer
	 */
	public function limit($limit);

	/**
	 * @param int $offset
	 * @return IResourceMailServer
	 */
	public function offset($offset);

	/**
	 * @param array $filter_map
	 * @return IResourceMailServer
	 */
	public function filter(array $filter_map);

	/** @return MailServer[] */
	public function fetchList();

	/**
	 * @param string $word
	 * @return MailServer[]
	 */
	public function search($word);

	/**
	 * @param array $data
	 * @return MailServer[]
	 */
	public function bulkCreate($data);
}
