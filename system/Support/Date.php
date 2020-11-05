<?php

namespace System\Support;

use System\ENV\AppEnv;
use \DateTime;
use \Inc;

/**
 * Class Date
 * @package System\Support
 */
class Date
{

    /**
     * @param $format
     *
     * @return string
     * @throws \Exception
     */
    public static function format($format)
    {
        
        self::timezone();
        
        $date = new DateTime(self::timezone());

        return $date->format($format);
        
    }

    /**
     * @param $format
     * @param $date
     *
     * @return bool|DateTime
     */
    public static function fromFormat($format, $date)
    {

        return DateTime::createFromFormat($format, $date);
        
    }

    /**
     * @param $num
     *
     * @return DateTime
     * @throws \Exception
     */
    public static function add($num)
    {
        
        $date = new DateTime(self::timezone());
        
        return $date->modify('+'.$num);
        
    }

    /**
     * @return DateTime
     * @throws \Exception
     */
    public static function away()
    {
        
        $date = new DateTime(self::timezone());
        
        return $date->modify('-'.$num);
        
    }

    /**
     * @param $num1
     * @param $num2
     * @param $num3
     *
     * @return DateTime
     * @throws \Exception
     */
    public static function set($num1, $num2, $num3)
    {
        
        $date = new DateTime(self::timezone());
        
        return $date->setDate($num1, $num2, $num3);
        
    }

    /**
     * @param $num1
     * @param $num2
     * @param   null $num3
     *
     * @return DateTime
     * @throws \Exception
     */
    public static function iso($num1, $num2, $num3 = null)
    {
        
        $date = new DateTime(self::timezone());
        
        return $date->setISODate($num1, $num2, $num3);
        
    }

    /**
     * @param $num1
     * @param $num2
     * @param   null $num3
     *
     * @return DateTime|false
     * @throws \Exception
     */
    public static function setTime($num1, $num2, $num3 = null)
    {
        
        $date = new DateTime(self::timezone());
        
        return $date->setTime($num1, $num2, $num3);
        
    }

    /**
     * @param $seconds
     *
     * @return DateTime
     * @throws \Exception
     */
    public static function unixDate($seconds)
    {

        $date = new DateTime(self::timezone());

        return $date->setTimestamp($seconds);

    }

    /**
     * @param $dateOne
     * @param $dateTwo
     *
     * @return \DateInterval|false
     * @throws \Exception
     */
    public static function diff($dateOne, $dateTwo)
    {
        $dateOne = new DateTime($dateOne);
        $dateTwo = new DateTime($dateTwo);
        
        return date_diff($dateOne, $dateTwo);
        
    }

    /**
     * @return int
     * @throws \Exception
     */
    public static function unix()
    {

        $date = new DateTime(self::timezone());

        return $date->getTimestamp();

    }

    /**
     * @param   int $seconds
     *
     * @return int|int
     * @throws \Exception
     */
    public static function addTime($seconds)
    {

        return static::unix() + $seconds;

    }

    /**
     * @param   int $seconds
     *
     * @return int|int
     * @throws \Exception
     */
    public static function awayTime($seconds)
    {

        return static::unix() - $seconds;

    }

    /**
     * @return mixed
     */
    private static function timezone()
    {
        $timeZone = AppEnv::get("DATETIME");

        date_default_timezone_set($timeZone);
        
        return $timeZone;
        
    }
    
    public function DateInSec($date)
    {
        
        $timeZone = AppEnv::get("DATETIME");
        
        date_default_timezone_set($timeZone);
        
        return strtotime($date);
        
    }
    
    
}