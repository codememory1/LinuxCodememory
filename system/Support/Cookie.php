<?php

namespace System\Support;

use Date;
use Random;

/**
 * Class Cookie
 * @package System\Support
 */
class Cookie
{

    /**
     * @var int
     */
    private $time = 1; // 1 day

    /**
     * @param $key
     *
     * @return bool
     */
    public function has($key)
    {
        
        return (isset($_COOKIE[$key])) ? true : false;
        
    }

    /**
     * @param $key
     * @param $value
     * @param   null $time
     *
     * @return bool
     */
    public function create($key, $value, $time = null, $patch = '/')
    {
        
        $time = (is_null($time)) ? Date::unix() + $this->time * 24 * 60 * 60 : Date::unix() + $time * 24 * 60 * 60;

        $randKey = Random::randInt(8);
            
        setcookie($key, $value, $time, $patch);
        
        return false;
    }

    /**
     * @param $key
     *
     * @return bool|mixed
     */
    public function get($key)
    {
        
        if($this->has($key) === true)
        {
            return $_COOKIE[$key];
        }
        return false;
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function delete($key)
    {
        
        if($this->has($key) === true)
        {
            setcookie($key, $value, Date::unix() - 3600);
        }
        return false;
    }

    
}