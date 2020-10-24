<?php

namespace System\ENV;

use System\ENV\AppEnv;

/**
 * Singleton
 */
class Single
{
    
    private function __construct() 
    {}

    private function __clone() 
    {}

    private function __wakeup() 
    {}

    /**
     * instance
     *
     * @var mixed
     */
    static private $instance;
    
    /**
     * isInstance
     *
     * @return void
     */
    static private function isInstance()
    {

        return self::$instance instanceof AppEnv;

    }
    
    /**
     * getInstance
     *
     * @return void
     */
    static public function getInstance() 
    {
        
       if(self::isInstance() === false) {

           self::$instance = new AppEnv();

           return self::$instance;

       }
       
    }

}