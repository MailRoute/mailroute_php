<?php
namespace MailRoute\API\Interfaces;

use MailRoute\API\Entity\OutboundServer;

interface IResourceOutboundServer
{
	/**
	 * @param string $id
	 * @return OutboundServer|OutboundServer[]
	 */
	public function get($id = '');

	/**
	 * @param array|object $data
	 * @return OutboundServer
	 */
	public function create($data);

	/**
	 * @param array|object $data
	 * @return OutboundServer
	 */
	public function update($data);

	/**
	 * @param int|string $id
	 * @return boolean
	 */
	public function delete($id);

	/**
	 * @param int $limit
	 * @return IResourceOutboundServer
	 */
	public function limit($limit);

	/**
	 * @param int $offset
	 * @return IResourceOutboundServer
	 */
	public function offset($offset);

	/**
	 * @param array $filter_map
	 * @return IResourceOutboundServer
	 */
	public function filter(array $filter_map);

	/** @return OutboundServer[] */
	public function fetchList();

	/**
	 * @param string $word
	 * @return OutboundServer[]
	 */
	public function search($word);

	/**
	 * @param array $data
	 * @return OutboundServer[]
	 */
	public function bulkCreate($data);
}
