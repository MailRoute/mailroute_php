<?php
namespace MailRoute\API;

interface AntiSpamMode
{
	const lenient    = 'lenient';
	const standard   = 'standard';
	const aggressive = 'aggressive';
}
