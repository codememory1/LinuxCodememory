<?php

namespace System\Database\FastDB;

use Store;
use Response;
use Request;
use Common;
use Env;
use System\Http\CurlRequest;

/**
 * Class HandleExecutionUpdate
 * @package System\Database\FastDB
 */
class HandleStorerDeletedData
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
     * path
     *
     * @var mixed
     */
    private $path;
    
    /**
     * basic
     *
     * @var mixed
     */
    private $basic;

    /**
     * HandleExecutionUpdate constructor.
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
        
        $this->path = \Customize::get('FastDB', 'BasicSettings');
        $this->basic = \Model::load('FastDB\\Basic');

        return Response::jsonToArray(Store::uncompress(Store::getApi($this->basic->server($this->path['patchTables'].'/'.$this->username.'/data-store.fd'))))[0];
		
	}

    
}