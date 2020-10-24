<?php

namespace System\Languages\Language;
use System\Languages\Language\Language;

/**
 * LanguageSingleton
 * @package System\Languages\Language
 */
class LanguageSingleton 
{
    
    private static $langObject;
    
    /**
     * check
     *
     * @return void
     */
    static private function check()
    {

        return self::$langObject instanceof Language;

    }
    
    /**
     * instance
     *
     * @return void
     */
    static public function instance()
    {
        
        if(self::check() === false) {

            self::$langObject = new Language();
 
            return self::$langObject;
 
        }
    }
    
    /**
     * __callStatic
     *
     * @param  mixed $name
     * @param  mixed $arguments
     * @return void
     */
    public static function __callStatic($name, $arguments)
    {
        return call_user_func_array([self::instance(), $name], $arguments);
    }
    
    /**
     * __call
     *
     * @param  mixed $name
     * @param  mixed $arguments
     * @return void
     */
    public function __call($name, $arguments)
    {

        return call_user_func_array([new Language(), $name], $arguments);

    }

}