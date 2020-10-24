<?php

namespace System\Classes\Facade;

use System\Support\Session;
use System\Classes\Facade\FacadeInterface;

/**
 * Class Facade
 * @package System\Classes\Facade
 */
class Facade implements FacadeInterface
{

    const PATCH_CONFIG_FACADE = '../config/Codememory/Facades';

    /**
     * @var array
     */
    public static $cgfFacade = [];

    /**
     * @var array
     */
    public static $cfgAliases = [];

    /**
     * @throws \ErrorException
     */
    protected static function lists()
    {
        
        $scan_facade = scandir(dirname(__DIR__) . '/../../system/Classes/Facade/Facades');
        array_shift($scan_facade);
        array_shift($scan_facade);
        
        $new_arr_facade = [];
        foreach($scan_facade as $key => $facade)
        {
            $new_arr_facade[] .= str_replace('.php', '', $facade);
        }

        foreach($new_arr_facade as $facade_arr)
        {
            $namespace_facade = 'System\\Classes\\Facade\\Facades\\'.$facade_arr;
            
            $class_facade = new $namespace_facade();
            $name_facade = $class_facade->installFacadeStatic();
            
            self::$cgfFacade[$name_facade] = self::listConfigFacade($name_facade);
            self::$cfgAliases[$name_facade] = self::listConfigAliases($name_facade);

        }
        
        
    }

    /**
     * @param $facade
     *
     * @return mixed|null
     */
    protected static function listConfigFacade($facade)
    {

        if(file_exists(dirname(__DIR__) . '/../config/Codememory/Facades.php'))
        {
            
            if(is_null($facade))
            {
				return require dirname(__DIR__) . '/../config/Codememory/facades.php';
            }
            return require (dirname(__DIR__) . '/../config/Codememory/facades.php')[$facade];
            
        }
        
        return null;
        
    }

    /**
     * @param $facade
     *
     * @return bool
     * @throws \ErrorException
     */
    protected static function listConfigAliases($facade)
    {
        
		$aliases = require dirname(__DIR__) . '/../../config/Codememory/aliases.php';
        if(array_key_exists($facade, $aliases))
        {
            return $aliases[$facade];
        } 
    }

    /**
     * @return mixed|void
     * @throws \ErrorException
     */
    public static function installStaticMethod()
    {
        
        self::lists();
        
    }

    

}