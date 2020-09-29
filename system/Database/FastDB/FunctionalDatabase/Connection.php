<?php

namespace System\Database\FastDB\FunctionalDatabase;

use System\Database\FastDB\FunctionalDatabase\Client;

class Connection
{
    
    /**
     * server
     *
     * @var mixed
     */
    private $server;
    
    /**
     * username
     *
     * @var mixed
     */
    private $username;
    
    /**
     * password
     *
     * @var mixed
     */
    private $password;
    
    /**
     * dbname
     *
     * @var mixed
     */
    private $dbname;
    
    /**
     * server
     *
     * @param  mixed $server
     * @return void
     */
    public function server($server)
    {

        $this->server = $server;

        return $this;

    }
    
    /**
     * username
     *
     * @param  mixed $user
     * @return void
     */
    public function username($user)
    {

        $this->username = $user;

        return $this;

    }
    
    /**
     * password
     *
     * @param  mixed $password
     * @return void
     */
    public function password($password)
    {

        $this->password = $password;

        return $this;

    }
    
    /**
     * dbname
     *
     * @param  mixed $dbname
     * @return void
     */
    public function dbname($dbname)
    {

        $this->dbname = $dbname;

        return $this;

    }
    
    /**
     * generateLinkConnection
     *
     * @return string
     */
    public function generateLinkConnection():string
    {

        return 'server='.$this->server.'&'.
            'username='.$this->username.'&'.
            'password='.$this->password.'&'.
            'dbname='.$this->dbname.'&';

    }
    
    /**
     * query
     *
     * @param  mixed $command
     * @return void
     */
    public function query($command)
    {

        $client = new Client();

        return $client->request($this->generateLinkConnection(), $command);

    }


}