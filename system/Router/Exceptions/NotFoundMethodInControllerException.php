<?php

namespace System\Router\Exceptions;

use \ErrorException;

/**
 * Class DontExistsDataUserException
 * @package System\Authentication\Exceptions
 */
class NotFoundMethodInControllerException extends ErrorException
{
	
	private $controller;
	
	private $method;
	
    /**
     * DontExistsDataUserException constructor.
     *
     * @param $user
     */
	public function __construct($controller, $method)
	{
		
		parent::__construct("Метод: [${method}] в контроллере: [${controller}] не найден.");
		
		$this->controller = $controller;
		$this->method = $method;
		
	}
	
	public function getController()
	{
		
		return $this->controller;
		
	}
	
	public function getMethod()
	{
		
		return $this->method;
		
	}
}