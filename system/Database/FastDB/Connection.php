<?php

namespace System\Database\FastDB;

use Env;
use System\Database\FastDB\FastDBQueryExecution as Execution;
use System\Database\FastDB\Exception\ConnectionException;
use Request;

/**
 * Class Connection
 * @package System\Database\FastDB
 */
class Connection
{

    /**
     * @var FastDBQueryExecution
     */
    public $connect;

    /**
     * Connection constructor.
     */
    public function __construct()
    {
        
        $server = Request::get('server');
        $username = Request::get('username');
        $password = Request::get('password');
        $db = Request::get('dbname');

        $connectClasses = new Execution(); 

        $this->connect = 
            $connectClasses
            ->connect(
            [
                'username' => $username, 
                'password' => $password, 
                'dbname' => $db
            ], 
            $server);
        
    }
    
}