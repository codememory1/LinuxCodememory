<?php

namespace System\Customize\Exceptions;

/**
 * Class InvalidKeyCustomizeException
 * @package System\Customize\Exceptions
 */
class InvalidKeyCustomizeException extends \ErrorException
{

    /**
     * @var string
     */
	private $customize;

    /**
     * InvalidKeyCustomizeException constructor.
     *
     * @param $customize
     */
	public function __construct($customize)
	{
		
		parent::__construct("Customize [${customize}] not found.");
		
		$this->customize = $customize;
		
	}

    /**
     * @return string
     */
	public function getCustomize()
	{
		
		return $this->customize;
		
	}
	
}