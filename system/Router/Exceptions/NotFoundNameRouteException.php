<?php

namespace System\Router\Exceptions;

use \ErrorException;

/**
 * Class DontExistsDataUserException
 * @package System\Authentication\Exceptions
 */
class NotFoundNameRouteException extends ErrorException
{
	
	private $name;
	
    /**
     * DontExistsDataUserException constructor.
     *
     * @param $user
     */
	public function __construct($name)
	{
		
		parent::__construct("Route с именем: [${name}] не существует.");
		
		$this->name = $name;
		
	}
	
	public function getName()
	{
		
		return $this->name;
		
	}
	
}