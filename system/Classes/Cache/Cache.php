<?php

namespace System\Classes\Cache;

use System\Classes\Cache\CacheInterface;
use \Fopen;
use \Random;

/**
 * Class Cache
 * @package System\Classes\Cache
 */
class Cache implements CacheInterface
{

    /**
     * @param $name
     *
     * @return bool|mixed
     */
    public function get($name)
    {
        
        return ($this->isCache($name) === true) ? 
            unserialize(Fopen::getContents('storage/cache/'.base64_encode($name).'_'.$name.'.cache')) : 
        false;
        
    }

    /**
     * @param $name
     *
     * @return bool
     */
    private function isCache($name)
    {
        
        return (file_exists('../storage/cache/'.base64_encode($name).'_'.$name.'.cache')) ? 
            true : 
        false;
        
    }

    /**
     * @param $name
     * @param $contents
     *
     * @return bool
     */
    private function isContent($name, $contents)
    {
        
        $content = Fopen::getContents('storage/cache/'.base64_encode($name).'_'.$name.'.cache');
        
        similar_text($content, serialize($contents), $num);
        
        return ($num == 100) ? 
            true : 
        false;
    }

    /**
     * @param $name
     * @param $content
     *
     * @return bool|mixed
     */
    public function create($name, $content)
    {

        if($this->isCache($name) === true)
        {
            
            if($this->isContent($name, $content) === false)
            {
                file_put_contents('../storage/cache/'.base64_encode($name).'_'.$name.'.cache', serialize($content));
            }
            return true;
            
        }else{
            
            file_put_contents('../storage/cache/'.base64_encode($name).'_'.$name.'.cache', serialize($content));
            
        }
        
    }

    /**
     * @param $name
     *
     * @return bool|mixed
     */
    public function clear($name)
    {
        
        if($this->isCache($name) === true)
        {
            file_put_contents('../storage/cache/'.base64_encode($name).'_'.$name.'.cache', '');
        }
        return false;
        
    }

    /**
     * @param $name
     *
     * @return bool|mixed
     */
    public function delete($name)
    {
        
        if($this->isCache($name) === true)
        {
            unlink('../storage/cache/'.base64_encode($name).'_'.$name.'.cache');
        }
        return false;
    }
    
}