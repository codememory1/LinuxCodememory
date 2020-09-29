<?php

namespace System\Classes;

use System\Classes\AliasesInterface;

/**
 * Class AliasesContainer
 * @package System\Classes
 */
class AliasesContainer implements AliasesInterface
{


    /**
     * @var array
     */
    private static $arr_list = [];

    /**
     * AliasesContainer constructor.
     */
    public function __construct()
    {

        self::arrayListAliases();
    }

    /**
     * @param $alias
     *
     * @return bool
     * @throws \ErrorException
     */
    private static function hasAlias($alias)
    {
        
        if(!class_exists($alias))
        {
            throw new \ErrorException(
                sprintf('Add alias is not possible. Class <strong>%s</strong> does not exist.', $alias)
            );

            return false;
        }

        return true;
        
    }

    private static function arrayListAliases()
    {
        
        $aliasses = require dirname(__DIR__) . '/../config/Codememory/aliases.php';
        
        self::$arr_list[] = $aliasses;
        
    }

    /**
     * @param $alias
     *
     * @return mixed|void
     * @throws \ErrorException
     */
    public static function get($alias) 
    {
        
        $list_arr = (array) self::$arr_list;
        
        foreach($list_arr as $aliase)
        {
            
            $facade = require dirname(__DIR__) . '/../config/Codememory/facades.php';
            
            if(array_key_exists($alias, $facade) && class_exists($aliase[$alias]))
            {
                (self::hasAlias($aliase[$alias]) === true) ? 
                    class_alias($facade[$alias], $alias) : 
                self::hasAlias($aliase[$alias]);
            }else{
                (self::hasAlias($aliase[$alias]) === true) ? 
                    class_alias($aliase[$alias], $alias) : 
                self::hasAlias($aliase[$alias]);
            }
            
        }
        
    }

    /**
     * @return mixed|void
     * @throws \ErrorException
     */
    public static function getList()
    {
        
        foreach(self::$arr_list as $aliase)
        {
            
            foreach($aliase as $name => $alias)
            {
                $facade = require dirname(__DIR__) . '/../config/Codememory/facades.php';
                
                if(array_key_exists($name, $facade) && class_exists($facade[$name]))
                {
                    (self::hasAlias($alias) === true) ? 
                        class_alias($facade[$name], $name) : 
                    self::hasAlias($alias);
                }else{
                    (self::hasAlias($alias) === true) ? 
                        class_alias($alias, $name) : 
                    self::hasAlias($alias);
                }
                
                
            }
            
        }
        
    }

    /**
     * @param $alias
     * @param $class
     *
     * @return mixed|void
     * @throws \ErrorException
     */
    public static function set($alias, $class)
    {

        
        (self::hasAlias($class) === true) ? 
                self::$arr_list[] = class_alias($class, $alias) : 
            self::hasAlias($aliase[$alias]);
        
    }
    
}