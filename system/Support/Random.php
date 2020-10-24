<?php

namespace System\Support;

/**
 * Class Random
 * @package System\Support
 */
class Random
{

    const REGEX_HASH = '/^[A-Z]{2}[0-9]{1}[a-z]{1}[0-9]{1}[A-Z]{1}[a-z]{3}[0-9]{2}[A-Z]{1}[a-z]{2}[A-Z]{1}[0-9]{3}[a-z]{2}[A-Z]{2}[a-z]{1}[0-9]{1}[A-Z]{1}[a-z]{1}[A-Z]{1}[a-z]{2}[0-9]{2}[A-Z]{3}[a-z]{2}$/';

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
    
    /**
     * randHash
     *
     * @return string
     */
    public function randHash():string
    {

        $randArr = [
            up_line($this->randString(2)),
            $this->randInt(1),
            down_line($this->randString(1)),
            $this->randInt(1),
            up_line($this->randString(1)),
            down_line($this->randString(3)),
            $this->randInt(2),
            up_line($this->randString(1)),
            down_line($this->randString(2)),
            up_line($this->randString(1)),
            $this->randInt(3),
            down_line($this->randString(2)),
            up_line($this->randString(2)),
            down_line($this->randString(1)),
            $this->randInt(1),
            up_line($this->randString(1)),
            down_line($this->randString(1)),
            up_line($this->randString(1)),
            down_line($this->randString(2)),
            $this->randInt(2),
            up_line($this->randString(3)),
            down_line($this->randString(2))
        ];


        $rand = null;

        foreach($randArr as $randStr)
        {
            $rand .= $randStr;
        }

        return $rand;
        
    }
    
    /**
     * isHash
     *
     * @param  mixed $hash
     * @return bool
     */
    public function isHash(string $hash):bool
    {

        if(preg_match(self::REGEX_HASH, $hash)) return true;
        else return false;

    }
    
}