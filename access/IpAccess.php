<?php

namespace Access;

use System\Http\Access\Access;

/**
 * Class IpAccess
 * @package Access
 */
class IpAccess
{

    public static function accessHandle()
    {

        if(\Common::getIp() === \Env::get('APP_IP'))
        {
            return true;
        }
        
        return false;

    }

}