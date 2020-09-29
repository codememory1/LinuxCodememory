<?php

namespace System\Classes\Facade\Facades;

use System\Classes\Facade\Facade;

/**
 * Class SessionFacade
 * @package System\Classes\Facade\Facades
 */
class PluginFacade extends Facade
{

    /**
     * @param $method
     * @param $params
     *
     * @return mixed
     */
    public static function __callStatic($method, $params)
    {
        $class = new self::$cfgAliases[self::installFacadeStatic()];
            
        return call_user_func_array([$class, $method], $params);

    }
    
    /**
     * @return string
     */
    public static function installFacadeStatic()
    {
        
        return 'Plugin';
        
    }
    
}