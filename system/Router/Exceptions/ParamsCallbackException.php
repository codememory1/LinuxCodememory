<?php

namespace System\Router\Exceptions;

use \ErrorException;

/**
 * Class DontExistsDataUserException
 * @package System\Authentication\Exceptions
 */
class ParamsCallbackException extends ErrorException
{
	
    /**
     * DontExistsDataUserException constructor.
     *
     * @param $user
     */
	public function __construct($message)
	{
		
		parent::__construct($message);
		
	}
	
}