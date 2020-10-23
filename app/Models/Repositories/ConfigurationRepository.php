<?php

namespace App\Models\Repositories;

use App\Models\stdConfiguration;
use Store;
use Session;
use Request;
use Response;

/**
 * ConfigurationRepository
 */
class ConfigurationRepository
{
    
	/**
     * algIp
     *
     * @var string
     */
	public $algIp = '/^[\d+]{3}\.[\d+]{3}\.[\d+]{2}\.[\d+]{2}\.[\d+]{1}$/';
	
	/**
     * algPort
     *
     * @var string
     */
    public $algPort = '/^[3333-9999]{4}$/';
        
    /**
     * algFullServer
     *
     * @var string
     */
    public $algFullServer = '/^[\d+]{3}\.[\d+]{3}\.[\d+]{2}\.[\d+]{2}\.[\d+]{1}\:[3-9]{4}$/';
	
    /**
     * path
     *
     * @var string
     */
    private $path = 'FastDB/';
    
    /**
     * pathServer
     *
     * @var string
     */
    private $pathServer = 'FastDB/Servers/%s/';
    
    /**
     * fileDatabase
     *
     * @var string
     */
    private $fileDatabase = 'database=%s';
    
    /**
     * pathDb
     *
     * @var string
     */
    private $pathDb = 'FastDB/Servers/%s/Databases/%s/';
    
    /**
     * pathTables
     *
     * @var string
     */
    private $pathTables = 'FastDB/Servers/%s/Tables/%s/';
    
    /**
     * fileTable
     *
     * @var string
     */
    private $fileTable = 'database=%s&table=%s';
        
    /**
     * getInfoConnect
     *
     * @param  mixed $key
     * @return void
     */
    public function getInfoConnect($key = null)
    {

        $info = [
            'username'     => Session::get('authorize')['login'] ?? Request::get('login-auth'),
            'password'     => Request::get('password'),
            'server'       => Session::get('authorize')['server'] ?? Request::get('server'),
            'dbname'       => Request::get('dbname'),
            'user-by-hash' => $this->getUserByHash(Request::get('hash-user') ?? '')
        ];
 
        return $info[$key] ?? $info;

    }

    /**
     * getUserByHash
     *
     * @param  mixed $hash
     * @return array
     */
    public function getUserByHash(string $hash, ?string $server = null):array
    {

        if($server !== null) {
            $servers = [
                $server
            ];
        }
        else $servers = Store::scan($this->getPath('Servers'));

        $dataUser = [
            'data' => [],
            'path' => ''
        ];

        foreach($servers as $server)
        {
            $users = Store::scan($this->getPath('Servers').'/'.$server.'/Users');

            foreach($users as $user)
            {
                $data = Response::jsonToArray(Store::getApi($this->getPath('Servers').'/'.$server.'/Users/'.$user.'/information-user.fd'));

                if($data['hash'] == $hash)
                {
                    $dataUser = [
                        'data' => $data,
                        'path' => $this->getPath('Servers').'/'.$server.'/Users/'.$user.'/information-user'
                    ];
                }
            }
        }

        return $dataUser;

    }
    
    /**
     * getUserData
     *
     * @param  mixed $server
     * @param  mixed $username
     * @return void
     */
    public function getUserData($server, $username)
    {

        $pathUser = $this->getPathServer($server, 'Users/'.$username.'/information-user.fd');

        return Response::jsonToArray(Store::getApi($pathUser));

    }


    /**
     * getPath
     *
     * @param  mixed $join
     * @return void
     */
    public function getPath(string $join)
    {

        return $this->path.$join;

    }
    
    /**
     * getPathServer
     *
     * @param  mixed $server
     * @param  mixed $join
     * @return void
     */
    public function getPathServer(string $server, string $join = null)
    {

        return sprintf($this->pathServer, $server).$join;

    }
    
    /**
     * getFileDb
     *
     * @param  mixed $dbname
     * @param  mixed $user
     * @return void
     */
    public function getFileDb(string $dbname)
    {

        return sprintf($this->fileDatabase, $dbname);

    }
    
    /**
     * getFileTable
     *
     * @param  mixed $dbname
     * @param  mixed $table
     * @return void
     */
    public function getFileTable(string $dbname, string $table)
    {

        return sprintf($this->fileDatabase, $dbname, $table);

    }
    
    /**
     * getPathDb
     *
     * @param  mixed $server
     * @param  mixed $user
     * @return void
     */
    public function getPathDb(string $server, string $user)
    {

        return sprintf($this->pathDb, $server, $user);

    }
    
    /**
     * getPathTable
     *
     * @param  mixed $server
     * @param  mixed $user
     * @return void
     */
    public function getPathTable(string $server, string $user)
    {

        return sprintf($this->pathTables, $server, $user);

    }
    
    /**
     * getPathHistory
     *
     * @return void
     */
    public function getPathHistory(string $server, string $username)
    {

        return $this->getPathServer($server, 'Users/'.$username.'/History/');

    }
    
    /**
     * getFullServer
     *
     * @return array
     */
    public function getFullServer($key = null)
    {

        list($server, $port) = explode(':', $this->getInfoConnect('server'));

        $data = [
            'server-dir'   => Store::replace([':' => '-'], $this->getInfoConnect('server')),
            'server-watch' => $this->getInfoConnect('server'),
            'server'       => $server,
            'port'         => $port
        ];

        if($key === null)
        {
            return $data;
        } else {
            return $data[$key];
        }

    }
    
    /**
     * getServer
     *
     * @return void
     */
    public function getServer()
    {

        return $this->getFullServer()['server'];

    }
    
    /**
     * getPort
     *
     * @return void
     */
    public function getPort()
    {

        return $this->getFullServer()['port'];

    }
    
    /**
     * getPathUser
     *
     * @param  mixed $server
     * @param  mixed $username
     * @return void
     */
    public function getPathUser(string $server, string $username)
    {

        return sprintf('FastDB/Servers/%s/Users/%s/', $server, $username);

    }
    
    /**
     * getUsername
     *
     * @return void
     */
    public function getUsername()
    {

        return $this->getInfoConnect('username');

    }


}