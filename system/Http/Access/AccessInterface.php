<?php

namespace System\Http\Access;

/**
 * Interface AccessInterface
 * @package System\Support\Access
 */
interface AccessInterface
{

    /**
     * @param $access
     *
     * @return mixed
     */
    public function get($access);

}