<?php

namespace System\Database;

use Env;
use Redis;

class DBRedis
{
    
    /**
     * connect
     *
     * @var mixed
     */
    private $connect;
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {

        $redis = new Redis();
        $redis->pconnect('127.0.0.1', 6379);

        $this->connect = $redis;

    }
    
    /**
     * __call
     *
     * @param  mixed $method
     * @param  mixed $params
     * @return void
     */
    public function __call($method, $params)
    {

        return call_user_func_array([$this->connect, $method], $params);

    }

}