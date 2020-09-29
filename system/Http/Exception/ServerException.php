<?php

namespace System\Http\Exception;

use \ErrorException;

/**
 * Class ServerException
 * @package System\Http\Exception
 */
class ServerException extends ErrorException
{

    /**
     * ServerException constructor.
     *
     * @param $message
     */
	public function __construct($message)
	{
		
		parent::__construct($message);
		
	}
	
}