<?php

namespace System\Database\FastDB;

use System\Database\FastDB\Exception\ConnectionException;
use System\Database\FastDB\Exception\ServerException;
use System\Database\FastDB\Exception\UserNotFoundException;
use System\Database\FastDB\Exception\DbNotFoundException;
use Exception;
use Store;
use Response;

/**
 * Class FastDBConnection
 * @package System\Database\FastDB
 */
abstract class FastDBConnection
{

    /**
     * @var array
     */
    private $servers = [];

    /**
     * @var bool
     */
    private $existsUser = false;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $dbname;

    /**
     * FastDBConnection constructor.
     *
     * @param   array $connection
     * @param $server
     */
    public function __construct(array $connection, $server)
    {
        $this->servers[] = $server;
        $this->connection($connection, $server);
    }
    
    /**
     * getServer
     *
     * @return void
     */
    public function getServer()
    {

        return Store::replace([':' => '-'], $this->servers[0]);

    }

    /**
     * @param   array $connection
     * @param $server
     *
     * @return $this
     * @throws ServerException
     * @throws UserNotFoundException
     */
    protected function connection(array $connection = [], $server)
    {

        $this->existenceServer($server);
        
        $username = (empty($connection['username'])) ? '?' : $connection['username'];
        $dbname = (empty($connection['dbname'])) ? '?' : $connection['dbname'];
        
        $this->existenceUser($username, $connection['password']);
        $this->existenceDb($dbname, $username);
        
        $this->username = $connection['username'];
        $this->password = $connection['password'];
        $this->dbname = $connection['dbname'];
        $this->servres[] = $server;
        
        return $this;
        
    }

    /**
     * @param $server
     *
     * @return bool
     * @throws ServerException
     */
    protected function existenceServer($server)
    {
        
        $servers = [];
        /** @var TYPE_NAME $servers */
        $servers = array_combine($this->servers, $this->servers);

        if(!array_key_exists($server, $servers)) 
        {
            throw new ServerException($server);
        }
        
        return true;
        
    }
    
    /**
     * existenceUser
     *
     * @param  mixed $username
     * @param  mixed $password
     * @return void
     */
    protected function existenceUser($username, $password)
    {

        $exists = Store::exists('FastDB/Server/'.$this->getServer().'/Users/ListUsers.json');

        if($exists === true)
        {
            $allUsers = Store::getApi('FastDB/Server/'.$this->getServer().'/Users/ListUsers.json');
            $allUsers = Store::uncompress($allUsers);
            $allUsers = Response::jsonToArray($allUsers)[0]['listsUsers'];
            
            $desiredUser = [];

            foreach($allUsers as $user)
            {
                $desiredUser += $user;
            }
            
            if(array_key_exists('username@'.$username, $desiredUser)) $this->existsUser = true;
                else 
                    throw new UserNotFoundException($username);
            
            if($this->existsUser === true)
            {
                if($this->comparisonPassword($username, $password, $allUsers) === true)
                    $this->comparisonPassword($username, $password, $allUsers);
                else
                    throw new UserNotFoundException($username);
            }
        }
        else 
            throw new UserNotFoundException($username);
        
    }

    /**
     * @param $username
     * @param $password
     * @param   array $users
     *
     * @return bool
     */
    protected function comparisonPassword($username, $password, array $users)
    {
        
        $specificUser = [];

        foreach($users as $user)
        {
            $specificUser += $user;
        }

        $kUser = 'username@'.$username;

        return ($specificUser[$kUser]['password'] == $password) ? true : false;
        
    }
    
    /**
     * @param $dbname
     * @param $username
     *
     * @throws UserNotFoundException
     * @return bool
     */
    protected function existenceDb($dbname, $username)
    {
        
        if(!Store::exists('FastDB/Server/'.$this->getServer().'/Databases/Database/'.$username.'/user='.$username.'&database='.$dbname.'.json'))
        {
           throw new DbNotFoundException($dbname, $username);
        }
        
        return true;
        
    }
    
}