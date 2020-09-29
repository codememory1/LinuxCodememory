<?php

namespace Access;

use System\Http\Access\Access;
use Session;
use Redirector;

/**
 * Class IpAccess
 * @package Access
 */
class AuthFastDBAccess
{

    public static function accessHandle()
    {
        if(!Session::get('authorize'))
        {
            exit(Redirector::route('FastDB.auth')->redirect());
        }
    }

}