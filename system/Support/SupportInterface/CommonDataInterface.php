<?php

namespace System\Support\SupportInterface;

/**
 * Interface CommonDataInterface
 * @package System\Support\Interface
 */
interface CommonDataInterface
{

    /**
     * @param $key
     * @param $value
     * @param   null $time
     *
     * @return mixed
     */
    public function create($key, $value, $time = null);

    /**
     * @param $key
     *
     * @return mixed
     */
    public function get($key);

    /**
     * @param $key
     *
     * @return mixed
     */
    public function delete($key);
    
}