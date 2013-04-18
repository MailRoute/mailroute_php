<?php
namespace MailRoute\API\Interfaces;

use MailRoute\API\Entity\NotificationAccountTask;

interface IResourceNotificationAccountTask
{
	/**
	 * @param string $id
	 * @return NotificationAccountTask|NotificationAccountTask[]
	 */
	public function get($id = '');

	/**
	 * @param array|object $data
	 * @return NotificationAccountTask
	 */
	public function create($data);

	/**
	 * @param array|object $data
	 * @return NotificationAccountTask
	 */
	public function update($data);

	/**
	 * @param int|string $id
	 * @return boolean
	 */
	public function delete($id);

	/**
	 * @param int $limit
	 * @return IResourceNotificationAccountTask
	 */
	public function limit($limit);

	/**
	 * @param int $offset
	 * @return IResourceNotificationAccountTask
	 */
	public function offset($offset);

	/**
	 * @param array $filter_map
	 * @return IResourceNotificationAccountTask
	 */
	public function filter(array $filter_map);

	/** @return NotificationAccountTask[] */
	public function fetchList();

	/**
	 * @param string $word
	 * @return NotificationAccountTask[]
	 */
	public function search($word);

	/**
	 * @param array $data
	 * @return NotificationAccountTask[]
	 */
	public function bulkCreate($data);
}
