<?php

namespace System\Inc;

/**
 * Class Make
 * @package System\Inc
 */
class FopenFile
{
    
    /**
     * @param $content_file
     *
     * @throws \Exception
     * @return bool
     */
    private static function hasFile($content_file)
    {
        
        if(!file_exists('../'.$content_file))
        {
            throw new \ErrorException(
                sprintf('File {%s} not found.', $content_file)
            );
        }
        
        return true;
        
    }
    
    /**
     * @param $patch
     *
     * @throws \Exception
     * @return bool
     */
    private static function hasFileWrite($patch)
    {
        
        if(!file_exists('../'.$patch))
        {
            return true;
        }
        
        return false;
        
    }
    
    /**
     * @param $patch
     *
     * @return mixed
     */
    public static function getContents($patch)
    {
        
        return (self::hasFile($patch) === true) ? file_get_contents('../'.$patch) : false;
        
    }
    
    /**
     * @param $patch
     * @param $what
     *
     * @return mixed
     */
    public static function setContents($patch, $what)
    {
        
        (self::hasFileWrite($patch) === true) ? file_put_contents('../'.$patch, $what, LOCK_EX) : false;
        
    }
    
}