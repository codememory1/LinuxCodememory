<?php

namespace System\Codememory\Components\Config\Exceptions;

use \ErrorException;

class InvalidConfigException extends ErrorException
{
	
	public function __construct($config)
	{
		
		parent::__construct("Кофиг <b>${config}</b> не найден.");
		
	}
	
}