<?php

namespace System\Database\FastDB\FunctionalDatabase;

use System\Database\FastDB\FunctionalDatabase\Connection;

/**
 * Query
 */
class Query
{
        
    /**
     * connection
     *
     * @var mixed
     */
    private $connection;
    
    /**
     * connect
     *
     * @var mixed
     */
    private $connect;
        
    /**
     * __construct
     *
     * @param  mixed $server
     * @param  mixed $username
     * @param  mixed $password
     * @param  mixed $dbname
     * @return void
     */
    public function __construct($server, $username, $password, $dbname)
    {

        $this->connection = new Connection();

        $this->connect = $this->connection
            ->server($server)
            ->username($username)
            ->password($password)
            ->dbname($dbname);

    }
    
    /**
     * query
     *
     * @param  mixed $command
     * @return void
     */
    public function query($command)
    {

        return $this->connect->query($command);

    }

}