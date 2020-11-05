<?php

namespace System\ENV;

/**
 * Class AppEnv
 * @package System\ENV
 */
class AppEnv
{
    
    /**
     * list
     *
     * @var array
     */
    static private $list = [];
    
    /**
     * set
     *
     * @param  mixed $key
     * @param  mixed $data
     * @return void
     */
    static public function set($key, $data = null)
    {

        $globalVar = (isset($_ENV[$key]) === 'null') ? '' : $_ENV[$key]; 

        self::$list[$key] = ($globalVar == '' || $globalVar === null || $globalVar == 'null') ? $data : $globalVar;

    }
    
    /**
     * get
     *
     * @param  mixed $key
     * @return void
     */
    static public function get($key)
    {

        if(self::exists($key) === true)
        {
            return self::$list[$key];
        }

        return null;

    }
    
    /**
     * exists
     *
     * @param  mixed $key
     * @return void
     */
    static public function exists($key)
    {

        return array_key_exists($key, self::$list);

    }
    
    /**
     * all
     *
     * @return void
     */
    static public function all()
    {

        return self::$list;

    }
    
}