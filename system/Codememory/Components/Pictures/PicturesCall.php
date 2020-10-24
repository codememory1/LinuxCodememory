<?php

namespace System\Codememory\Components\Pictures;

/**
 * PicturesCall
 */
class PicturesCall
{
    
    /**
     * __call
     *
     * @param  mixed $method
     * @param  mixed $args
     * @return void
     */
    public function __call($method, $args)
    {

        $handler = 'System\Codememory\Components\Pictures\PicturesHandler';

        return call_user_func_array([new $handler(), $method], $args);

    }

}