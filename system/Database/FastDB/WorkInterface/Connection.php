<?php

namespace System\Database\FastDB\WorkInterface;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use System\Database\FastDB\WorkInterface\Repositorys\DefaultRepository;
use System\Database\FastDB\WorkInterface\Components;

class Connection
{
    
    /**
     * server
     *
     * @var string
     */
    private $server;

    /**
     * port
     *
     * @var int
     */
    private $port;
    
    /**
     * username
     *
     * @var string
     */
    private $username;
    
    /**
     * password
     *
     * @var string
     */
    private $password;
    
    /**
     * dbname
     *
     * @var string
     */
    private $dbname;
            
    /**
     * connect
     *
     * @param  mixed $server
     * @param  mixed $port
     * @param  mixed $username
     * @param  mixed $password
     * @param  mixed $dbname
     * @return Components
     */
    public function connect(string $server, int $port, string $username, ?string $password, string $dbname):Components
    {

        $password = $password == '' || $password === null ? 'null' : $password;

        $this->server = $server;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;

        return new Components($this);

    }

    /**
     * getFullServer
     *
     * @param  mixed $separator
     * @return void
     */
    public function getFullServer(string $separator = ':'):string
    {

        return $this->server.$separator.$this->port;

    }
    
    /**
     * getServer
     *
     * @return string
     */
    public function getServer():string
    {

        return $this->server;

    }
    
    /**
     * getPort
     *
     * @return int
     */
    public function getPort():int
    {

        return $this->port;

    }
    
    /**
     * getUsername
     *
     * @return string
     */
    public function getUsername():string
    {

        return $this->username;

    }
    
    /**
     * getDbname
     *
     * @return string
     */
    public function getDbname():string
    {

        return $this->dbname;

    }
    
    /**
     * getPassword
     *
     * @return void
     */
    public function getPassword()
    {

        return $this->password;

    }

}