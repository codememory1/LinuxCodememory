<?php

namespace System\Authentication\Exceptions;

use \ErrorException;

/**
 * Class DontExistsDataUserException
 * @package System\Authentication\Exceptions
 */
class DontExistsDataUserException extends ErrorException
{

    /**
     * @var string
     */
	private $user;

    /**
     * DontExistsDataUserException constructor.
     *
     * @param $user
     */
	public function __construct($user)
	{
		
		parent::__construct("Данные пользователя: <b>${user}</b> не найдены.");
		
		$this->user = $user;
		
	}

    /**
     * @return string
     */
	public function getUser()
	{
		
		return $this->user;
		
	}
	
}