<?php
namespace MailRoute\API\Interfaces;

use MailRoute\API\Entity\NotificationDomainTask;

interface IResourceNotificationDomainTask
{
	/**
	 * @param string $id
	 * @return NotificationDomainTask|NotificationDomainTask[]
	 */
	public function get($id = '');

	/**
	 * @param array|object $data
	 * @return NotificationDomainTask
	 */
	public function create($data);

	/**
	 * @param array|object $data
	 * @return NotificationDomainTask
	 */
	public function update($data);

	/**
	 * @param int|string $id
	 * @return boolean
	 */
	public function delete($id);

	/**
	 * @param int $limit
	 * @return IResourceNotificationDomainTask
	 */
	public function limit($limit);

	/**
	 * @param int $offset
	 * @return IResourceNotificationDomainTask
	 */
	public function offset($offset);

	/**
	 * @param array $filter_map
	 * @return IResourceNotificationDomainTask
	 */
	public function filter(array $filter_map);

	/** @return NotificationDomainTask[] */
	public function fetchList();

	/**
	 * @param string $word
	 * @return NotificationDomainTask[]
	 */
	public function search($word);

	/**
	 * @param array $data
	 * @return NotificationDomainTask[]
	 */
	public function bulkCreate($data);
}
