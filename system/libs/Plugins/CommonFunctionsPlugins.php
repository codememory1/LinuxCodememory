<?php

use System\Http\Url;

$obj = new \stdClass();

$obj->Url = new Url();

if(!function_exists('patch_plugin'))
{
    function patch_plugin($plugin, $patch = null)
    {
		global $obj;
        return $obj->Url->join('system/Plugins/Plugins/'.$plugin.'/'.$patch);
    }
}
