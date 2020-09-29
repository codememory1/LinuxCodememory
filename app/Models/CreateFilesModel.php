<?php

namespace App\Models;

use System\Codememory\RegisterService;
use Store;
use File;
use Response;

/**
 * CreateFilesModel
 * @package System\Codememory
 */
class CreateFilesModel extends RegisterService
{
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        
        parent::__construct();

    }
    
    /**
     * createDatabase
     *
     * @param  mixed $server
     * @param  mixed $username
     * @param  mixed $dbname
     * @param  mixed $data
     * @return void
     */
    public function createDatabase(string $server, string $username, string $dbname, array $data)
    {

        $path = sprintf('FastDB/Servers/%s/Databases/%s/', $server, $username);
        $name = 'database='.$dbname;

        Store::createDir($path.$name);
        File::create($path.$name.'/information-database.fd');
        Store::overwrite($path.$name.'/information-database', Response::arrayToJson($data), '.fd');
        Store::createDir($path.$name.'/Tables');

    }
    
    /**
     * createTable
     *
     * @param  mixed $server
     * @param  mixed $username
     * @param  mixed $dbname
     * @param  mixed $table
     * @param  mixed $data
     * @return void
     */
    public function createTable(string $server, string $username, string $dbname, string $table, array $data)
    {

        $path = sprintf('FastDB/Servers/%s/Databases/%s/', $server, $username).'database='.$dbname.'/Tables/';

        Store::createDir($path.'table='.$table);
        Store::overwrite($path.'table='.$table.'/structure', Response::arrayToJson($data['structure']), '.fd');
        Store::overwrite($path.'table='.$table.'/data', Response::arrayToJson($data['data']), '.fd');
        Store::createDir($path.'table='.$table.'/Store');
        Store::overwrite($path.'table='.$table.'/Store'.'/deleted-data', Response::arrayToJson([]), '.fd');

    }
    
    /**
     * createUser
     *
     * @param  mixed $server
     * @param  mixed $username
     * @param  mixed $data
     * @return void
     */
    public function createUser(string $server, string $username, array $data)
    {

        $path = sprintf('FastDB/Servers/%s/', $server);
        $pathhAllUsers = 'FastDB/Users/list-all-users';

        Store::createDir($path.'Users/'.$username);
        Store::createDir($path.'Databases/'.$username);
        Store::overwrite($path.'Users/'.$username.'/information-user', Response::arrayToJson($data['data']), '.fd');
        Store::overwrite($path.'Users/'.$username.'/logger-info', Response::arrayToJson($data['logger']), '.log');
        Store::createDir($path.'Users/'.$username.'/History');
        Store::overwrite($path.'Users/'.$username.'/History/history-data', Response::arrayToJson([]), '.fd');
        
        $allArr = Response::jsonToArray(Store::getApi($pathhAllUsers.'.fd'));

        $allArr[] = [
            'server'   => $data['data']['server'].':'.$data['data']['port'],
            'login'    => $data['data']['username'],
            'password' => $data['data']['password']
        ];

        Store::overwrite($pathhAllUsers, Response::arrayToJson($allArr), '.fd');

    }
    
    /**
     * deleteUser
     *
     * @param  mixed $server
     * @param  mixed $userid
     * @param  mixed $username
     * @return void
     */
    public function deleteUser(string $server, int $userid, string $username)
    {

        $path = sprintf('FastDB/Servers/%s/', $server);
        $pathhAllUsers = 'FastDB/Users/list-all-users';

        Store::completeRemove($path.'Users/'.$username);
        Store::completeRemove($path.'Databases/'.$username);

        $allArr = Response::jsonToArray(Store::getApi($pathhAllUsers.'.fd'));
        unset($allArr[$userid]);

        Store::overwrite($pathhAllUsers, Response::arrayToJson($allArr), '.fd');

    }

}