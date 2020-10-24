<?php

namespace System\Router\Exceptions;

use \ErrorException;

/**
 * Class DontExistsDataUserException
 * @package System\Authentication\Exceptions
 */
class NotFoundControllerException extends ErrorException
{
	
	private $controller;
	
    /**
     * DontExistsDataUserException constructor.
     *
     * @param $user
     */
	public function __construct($controller)
	{
		
		parent::__construct("Контроллер: [${controller}] не найден.");
		
		$this->controller = $controller;
		
	}
	
	public function getController()
	{
		
		return $this->controller;
		
	}
	
}