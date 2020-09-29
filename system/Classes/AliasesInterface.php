<?php

namespace System\Classes;

/**
 * Interface AliasesInterface
 * @package System\Classes
 */
interface AliasesInterface
{
    
    /*
    * ============================================
    *
    * Функция {get}, получает определенный алиас 
    * Указава параметр $alias
    * 
    * ============================================
    */
    /**
     * @param $alias
     *
     * @return mixed
     */
    public static function get($alias);
    
    /*
    * ============================================
    *
    * Функция {getList}, получает полный список 
    * Алиасов
    * 
    * ============================================
    */
    /**
     * @return mixed
     */
    public static function getList();
    
    /*
    * ============================================
    *
    * Функция {set}, добавляет новый алиас
    * Указав 2 параметра $alias - Имя алиаса
    * $class - namespace к классу
    * 
    * ============================================
    */
    /**
     * @param $alias
     * @param $class
     *
     * @return mixed
     */
    public static function set($alias, $class);
    
}