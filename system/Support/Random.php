<?php

namespace System\Support;

/**
 * Class Random
 * @package System\Support
 */
class Random
{
    /**
     *
     * @var type 
     */
    private static $regular = [

        "int"    => "0123456789",
        "string" => "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM",
        "any"    => "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789"
        
    ];

    /**
     * @param   int $max
     * @param   string $array
     *
     * @return bool|string
     */
    public static function randInt($max = 32, $array = "int")
    {
        return substr(str_shuffle(self::$regular[$array]), 0, $max);
        
    }

    /**
     * @param   int $max
     * @param   string $array
     *
     * @return bool|string
     */
    public static function randString($max = 32, $array = "string")
    {
        
        return substr(str_shuffle(self::$regular[$array]), 0, $max);
        
    }

    /**
     * @param   int $max
     * @param   string $array
     *
     * @return bool|string
     */
    public static function randAny($max = 46, $array = "any")
    {
        
        return substr(str_shuffle(self::$regular[$array]), 0, $max);
        
    }
    
    /**
     * randHis
     *
     * @param  mixed $max
     * @param  mixed $randString
     * @return void
     */
    public static function randHis($max = 1, string $randString)
    {

        return substr(str_shuffle($randString), 0, $max);

    }

    /**
     * @param   array $regular
     *
     * @return bool
     */
    public static function setRand($regular = [])
    {
        foreach($regular as $key => $set)
        {
            if(!array_key_exists($key, self::$regular))
            {
                self::$regular[$key] = $set;
            }
            return false;
        }
    }
    
}