<?php

namespace System\Http\Exception;

use \ErrorException;

/**
 * Class CodeUrlException
 * @package System\Http\Exception
 */
class CodeUrlException extends ErrorException
{

    /**
     * CodeUrlException constructor.
     */
	public function __construct()
	{
		
		parent::__construct('The code parameter should be: <b>int<b>, <b>string<b>');
		
	}
	
}