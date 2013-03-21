<?php
namespace MailRoute\API;

interface IEntity
{
	public function GET($id = '');

	public function POST($data);

	public function PUT($data);

	public function DELETE($id);
}
