<?php

namespace System\Codememory\Components\Template\Big\Interfaces;

/**
 * ConfigurationInterface
 * @package System\Codememory\Components\Template\Big\Interfaces
 */
interface ConfigurationInterface
{

    const EXPANSION = '.big';
    
    /**
     * compress
     *
     * @param  mixed $status
     * @return void
     */
    public function compress(bool $status);
    
    /**
     * saveCache
     *
     * @param  mixed $path
     * @return void
     */
    public function cache(string $path);

}