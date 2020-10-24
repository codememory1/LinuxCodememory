<?php

namespace System\Codememory\Components\Template\Big;

use System\Codememory\Components\Template\Big\Interfaces\ConfigurationInterface;

/**
 * Configuration
 * @package System\Codememory\Components\Template\Big
 */
class Configuration implements ConfigurationInterface
{
    
    /**
     * compress
     *
     * @var bool
     */
    private $compress = true;
    
    /**
     * cache
     *
     * @var mixed
     */
    private $cache = '/';
    
    /**
     * autoDeleteTemplate
     *
     * @var bool
     */
    private $autoDeleteTemplate = false;
    
    /**
     * compress
     *
     * @param  mixed $status
     * @return void
     */
    public function compress(bool $status)
    {

        $this->compress = $status;

        return $this;

    }
    
    /**
     * saveCache
     *
     * @param  mixed $path
     * @return void
     */
    public function cache(string $path) 
    {

        $this->cache = trim($path, '/').'/';

        return $this;

    }
    
    /**
     * autoDeleteTemplate
     *
     * @param  mixed $status
     * @return void
     */
    public function autoDeleteTemplate(bool $status)
    {

        $this->autoDeleteTemplate = $status;

        return $this;

    }
    
    /**
     * __get
     *
     * @param  mixed $property
     * @return void
     */
    public function __get($property)
    {

        return $this->$property;

    }
    
}