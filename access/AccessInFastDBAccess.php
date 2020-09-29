<?php

namespace Access;

use System\Http\Access\Access;
use Session;
use Env;
use Server;
use Response;

/**
 * Class IpAccess
 * @package Access
 */
class AccessInFastDBAccess
{

    public static function accessHandle()
    {

		$listArrayIp = explode(',', Env::get('APP_IP'));
		
		$status = false;
		
		foreach($listArrayIp as $ip)
		{
			$ip = trim($ip);
			
			if($ip == Server::get('REMOTE_ADDR'))
				$status = true;
		}
		
		if($status === false)
			Response::setResponseCode(404);
		
    }

}