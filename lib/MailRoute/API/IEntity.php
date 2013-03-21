<?php
namespace MailRoute\API;

interface IEntity
{
	/**
	 * In case of changing arguments of this method, change method EntityHandler::handleMethod() also
	 * @param int|string $id
	 * @param array $filters
	 * @param int $offset
	 * @param int $limit
	 * @return array
	 */
	public function GET($id = '', $filters = array(), $offset = 0, $limit = 0);

	public function POST($data);

	public function PUT($data);

	public function DELETE($id);
}
