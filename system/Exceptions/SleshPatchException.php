<?php

namespace System\Exceptions;

use \ErrorException;

class SleshPatchException extends ErrorException
{
	
	public function __construct()
	{
		
		parent::__construct("
			<b>Последний подключаемый шаблон, не может быть подключен. Замените / на .</b>
		");
		
	}
	
}