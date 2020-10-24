<?php

namespace System\Database\FastDB;

use Response;
use Store;
use Request;
use Env;
use Common;
use System\Http\CurlRequest;

/**
 * Class HandleExecutionEmbed
 * @package System\Database\FastDB
 */
class HandleExecutionShowDatabases
{

    /**
     * @var array
     */
    private $data;

    /**
     * @var string
     */
	private $table;

    /**
     * @var string
     */
	private $dbname;

    /**
     * @var string
     */
	private $username;

    /**
     * @var array
     */
	private $paramsExecute = [];
	
	/**
	 * server
	 *
	 * @var mixed
	 */
	private $server;
	   	
   	/**
   	 * __construct
   	 *
   	 * @param  mixed $data
   	 * @param  mixed $table
   	 * @param  mixed $dbname
   	 * @param  mixed $username
   	 * @param  mixed $paramsExecute
   	 * @param  mixed $server
   	 * @return void
   	 */
   	public function __construct(array $data, $table, $dbname, $username, $paramsExecute, $server)
   	{
	   
		$this->data = $data;
	   	$this->table = $table;
	   	$this->dbname = $dbname;
		$this->username = $username;
		$this->paramsExecute = $paramsExecute;
		$this->server = $server;
	   
   	}
	
	/**
	 * handle
	 *
	 * @return void
	 */
	public function handle()
	{
		
        \Customize::get('FastDB', 'GetDbTables');
        
        $list = getDbTables($this->username, $this->server);
        $newData = [];

        foreach($list as $db => $tables)
        {
            list($database, $dbName) = explode('=', $db);
            
            if($this->paramsExecute['with'] == 'TABLES')
            {
                if(count($tables) > 0)
                {
                    foreach($tables as $table)
                    {
                        list($contextTable) = explode('.', $table);
                        $explodeTableName = explode('=', $contextTable);
                        
                        $newData[$dbName][] = $explodeTableName[2];
                    }
                }
            }
            if($this->paramsExecute['with'] == 'DB')
            {
                $newData[] = $dbName;
            }
        }

        return $newData ?? [];
		
	}
    
}