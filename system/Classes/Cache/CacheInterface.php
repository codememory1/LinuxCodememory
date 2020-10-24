<?php

namespace System\Classes\Cache;

/**
 * Interface CacheInterface
 * @package System\Classes\Cache
 */
interface CacheInterface 
{
    
    /*
    * ============================================
    *
    * Функция {get}, получает содержимое кеша
    * Указав имя кеша
    * 
    * ============================================
    */
    /**
     * @param $name
     *
     * @return mixed
     */
    public function get($name);
    
    /*
    * ============================================
    *
    * Функция {set}, создает кеш, Указав имя кеша
    * И содержимое кеша
    * 
    * ============================================
    */
    /**
     * @param $name
     * @param $content
     *
     * @return mixed
     */
    public function create($name, $content);
    
    /*
    * ============================================
    *
    * Функция {clear}, очищает кеш, Указав имя кеша
    * 
    * ============================================
    */
    /**
     * @param $name
     *
     * @return mixed
     */
    public function clear($name);
    
    /*
    * ============================================
    *
    * Функция {delete}, удаляет кеш, Указав имя кеша
    * 
    * ============================================
    */
    /**
     * @param $name
     *
     * @return mixed
     */
    public function delete($name);
    
}