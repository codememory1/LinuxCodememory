<?php

namespace Access;

use System\Http\Access\Access;
use Session;
use Redirector;

/**
 * Class IpAccess
 * @package Access
 */
class FastDbDoAuthAccess
{

    public static function accessHandle()
    {

        if(Session::has('authorize') === true)
        {
            exit(Redirector::route('FastDB.all-db')->redirect());
        }

    }

}