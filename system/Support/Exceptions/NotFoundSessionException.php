<?php

namespace System\Support\Exceptions;

use \ErrorException;

/**
 * Class NotFoundSessionException
 * @package System\Support\Exceptions
 */
class NotFoundSessionException extends ErrorException
{

    /**
     * @var string
     */
	private $session;

    /**
     * NotFoundSessionException constructor.
     *
     * @param $session
     */
	public function __construct($session)
	{
		
		parent::__construct("Сессия: <b>${session}</b> не создана.");
		
		$this->session = $session;
		
	}

    /**
     * @return string
     */
	public function getSession()
	{
		
		return $this->session;
		
	}
	
}