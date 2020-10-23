<?php

namespace Access;

use System\Http\Access\Access;
use Session;
use Redirector;
use Request;
use App\Models\AuthModel;

/**
 * Class IpAccess
 * @package Access
 */
class FastDbDoAuthAccess
{

    public static function accessHandle()
    {

        $servers = Request::get('server') ?? '';
        list($server, $port) = explode(':', $servers);

        $login = Request::get('login-auth') ?? '';
        $password = Request::get('password') ?? '';

        $model = new AuthModel();

        $authMethod = $model->curlAuth($server, $port, $login, $password);
        

        if(Session::has('authorize') === true || (Session::has('authorize') === null && $authMethod === true))
        {
            Redirector::route('FastDB.all-db')->redirect();
            exit();
        }

    }

}