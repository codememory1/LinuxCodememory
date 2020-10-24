<?php

namespace FastDB\ComponentsClasses;

use Date;
use Store;
use Response;

/**
 * ComponentTypes
 */
class ComponentDefaults
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
     * dbname
     *
     * @var mixed
     */
    private $dbname;    

    /**
     * table
     *
     * @var mixed
     */
    private $table;

    /**
     * __construct
     *
     * @param  mixed $server
     * @param  mixed $username
     * @param  mixed $dbname
     * @param  mixed $table
     * @return void
     */
    public function __construct(string $server, string $username, ?string $dbname = null, ?string $table = null)
    {
        
        $this->server = $server;
        $this->username = $username;
        $this->dbname = $dbname;
        $this->table = $table;

    }
        
    /**
     * Null
     *
     * @return void
     */
    public function Null()
    {

        return 'null';

    }
        
    /**
     * Date
     *
     * @return string
     */
    public function Date():string
    {

        return Date::format('Y-m-d');

    }
    
    /**
     * Datetime
     *
     * @return string
     */
    public function Datetime():string
    {

        return Date::format('Y-m-d H:i:s');

    }
    
    /**
     * Timestamp
     *
     * @return int
     */
    public function Timestamp():int
    {

        return Date::unix();

    }
    
    /**
     * Autoid
     *
     * @return int
     */
    public function Autoid():int
    {

        $pathIntTable = 'FastDB/Servers/%s/Databases/%s/database=%s/Tables/table=%s/';
        $fullPath = sprintf($pathIntTable, $this->server, $this->username, $this->dbname, $this->table);
        
        $dataTable = Response::jsonToArray(Store::getApi($fullPath.'data.fd'));

        return $dataTable['statistics']['all-request'] + 1;

    }

}