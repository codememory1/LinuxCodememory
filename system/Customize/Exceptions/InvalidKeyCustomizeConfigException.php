<?php

namespace System\Customize\Exceptions;

/**
 * Class InvalidKeyCustomizeConfigException
 * @package System\Customize\Exceptions
 */
class InvalidKeyCustomizeConfigException extends \ErrorException
{

    /**
     * @var string
     */
	private $customize;

    /**
     * @var string
     */
	private $config;

    /**
     * InvalidKeyCustomizeConfigException constructor.
     *
     * @param $customize
     * @param $config
     */
	public function __construct($customize, $config)
	{
		
		parent::__construct("Config [${config}] in customize [${customize}] not found.");
		
		$this->customize = $customize;
		$this->config = $config;
		
	}

    /**
     * @return string
     */
	public function getCustomize()
	{
		
		return $this->customize;
		
	}

    /**
     * @return string
     */
	public function getConfig()
	{
		
		return $this->config;
		
	}
	
}