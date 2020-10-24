<?php

namespace System\Database\FastDB;

use Response;
use Request;
use Common;
use Env;

/**
 * Class HandleExecutionDelete
 * @package System\Database\FastDB
 */
class HandleExecutionCount
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
     * HandleExecutionDelete constructor.
     *
     * @param   array $data
     * @param $table
     * @param $dbname
     * @param $username
     * @param $paramsExecute
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
		
		return count($this->data);
		
	}
    
}