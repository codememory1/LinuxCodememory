<?php

namespace System\Codememory\Components\Config\Exceptions;

use \ErrorException;

class InvalidKeyInConfigException extends ErrorException
{
	
	public function __construct($config, $key)
	{
		
		parent::__construct("Ключ <b>${key}</b> в конфиге <b>${config}</b> не найден.");
		
	}
	
}