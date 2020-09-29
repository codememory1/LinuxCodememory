<?php

namespace System\Http\Access;

use System\Http\Access\Access;
use System\Http\Access\AccessInterface;

/**
 * Class Handle
 * @package System\Http\Access
 */
class Handle implements AccessInterface
{

    /**
     * @param $access
     * @param $task
     *
     * @return mixed|void
     */
    public function get($access, $task = null)
    {

        $class_access = new Access($access, $task);


    }

}