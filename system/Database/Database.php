<?php

namespace System\Database;

use Env;
use File;
use Url;

require Url::join('system/libs/rb.php');

/**
 * Class Database
 * @package System\Database
 */
class Database 
{
    
    /**
     * rb
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
        
        $server = 'mysql';
        $host = Env::get('DB_HOST');
        $dbname = Env::get('DB_NAME');
        $username = Env::get('DB_USERNAME');
        $password = Env::get('DB_PASSWORD');

        if(!is_null($host) && !is_null($dbname) && !is_null($username))
        {
            $this->connect = \R::setup($this->renderDsn($server, $host, $dbname), $username, $password);

            \R::testConnection() === false ? exit('Ошибка подключение к базе данных!') : false;
        }

    }
    
    /**
     * renderDsn
     *
     * @param  mixed $server
     * @param  mixed $host
     * @param  mixed $dbname
     * @return void
     */
    private function renderDsn(string $server, string $host, string $dbname):string
    {

        $dsn = $server.':'.
            'host='.$host.';'.
            'dbname='.$dbname.';';

        return $dsn;

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

        return call_user_func_array(['R', $method], $params);

    }
    
    /**
     * __callStatic
     *
     * @param  mixed $method
     * @param  mixed $params
     * @return void
     */
    public static function __callStatic($method, $params)
    {

        return call_user_func_array(['R', $method], $params);

    }

}

