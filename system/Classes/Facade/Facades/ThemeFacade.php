<?php

namespace System\Classes\Facade\Facades;

use System\Classes\Facade\Facade;
use System\Inc\IncFile;

/**
 * Class SessionFacade
 * @package System\Classes\Facade\Facades
 */
class ThemeFacade extends Facade
{
    
    /**
     * @param $method
     * @param $params
     *
     * @return mixed
     */
    public static function __callStatic($method, $params)
    {

        
        $params = [
            [
                'params' => $params,
                'method' => [
                    'method' => $method
                ]
            ]
        ];
        
        $class = new self::$cfgAliases[self::installFacadeStatic()];
        
        return call_user_func_array([$class, 'loadTheme'], $params);

    }


    
    /**
     * @return string
     */
    public static function installFacadeStatic()
    {
        
        return 'Theme';
        
    }
    
}