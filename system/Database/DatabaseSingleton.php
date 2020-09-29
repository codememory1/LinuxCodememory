<?php

namespace System\Database;

use Env;
use System\Database\Database;

/**
 * Class Database
 * @package System\Database
 */
class DatabaseSingleton
{
    
    /**
     * instance
     *
     * @var mixed
     */
    private static $instance;

    /**
     * checkInstance
     *
     * @return void
     */
    private static function checkInstance()
    {

        return self::$instance instanceof Database;

    }
    
    /**
     * getInstance
     *
     * @return void
     */
    public static function getInstance()
    {

        if(self::checkInstance() === false)
        {
            self::$instance = new Database();
            
            return self::$instance;
        }
        

    }

    /**
     * __callStatic
     *
     * @param  mixed $method
     * @param  mixed $params
     * @return void
     */
    public static function __callStatic($method, $params)
    {

        self::getInstance();

        return call_user_func_array([self::$instance, $method], $params);

    }
    
    /**
     * __call
     *
     * @param  mixed $method
     * @param  mixed $params
     * @return void
     */
    public function __call($method, $params)
    {

        self::getInstance();

        return call_user_func_array([self::$instance, $method], $params);

    }


}

