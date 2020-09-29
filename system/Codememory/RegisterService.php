<?php

namespace System\Codememory;

use System\Codememory\CodememoryContainer;

/**
 * Class RegisterService
 * @package System\Codememory
 */
class RegisterService
{

    /**
     * @var array
     */
	private $services = [];

    /**
     * RegisterService constructor.
     */
	public function __construct()
	{
		
		$container = new CodememoryContainer();
		$container->generateServices();
		
		$this->services = $container->services;
		
	}

    /**
     * @param $service
     *
     * @return mixed
     */
	public function __get($service)
	{
		return $this->services[$service];
	}

}