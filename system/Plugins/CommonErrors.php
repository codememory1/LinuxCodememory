<?php

namespace System\Plugins;

/**
 * Class CommonErrors
 * @package System\Plugins
 */
class CommonErrors
{

    /**
     * @var string|array|int
     */
	private static $error;

    /**
     * @param $error
     */
	public static function getError($error)
	{
		
		echo $error;
		
	}
	
}