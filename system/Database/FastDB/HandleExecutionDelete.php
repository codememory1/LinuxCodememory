<?php

namespace System\Database\FastDB;

use Response;
use Request;
use System\Http\CurlRequest;
use Common;
use Env;

/**
 * Class HandleExecutionDelete
 * @package System\Database\FastDB
 */
class HandleExecutionDelete
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
		
		return $this->delete();
		
	}

    /**
     *
     * Метод удаление записи
     *
     */	
	/**
	 * delete
	 *
	 * @return void
	 */
	private function delete()
	{
		
		foreach($this->data as $key => $dataArr)
		{
			
			$curl = new CurlRequest();

			$t = $curl->init(Env::get('APP_URL').
				route('FastDB.delete-data', ['db' => $this->dbname, 'table' => $this->table, 'id' => $key]).
				Common::collectParameters(['username' => $this->username, 'server' => $this->server])
			)
			->method('GET')
			->response();

		
			

			// $sendCurl = Request::send(
			// 	Env::get('APP_URL').
			// 	route('FastDB.delete-data', ['db' => $this->dbname, 'table' => $this->table, 'id' => $key]).
			// 	Common::collectParameters(['username' => $this->username, 'server' => $server])
			// );
			// $option = $sendCurl->option();
			// $reply = $option->reply();
			// $close = $reply->close();
			
		}
		
	}
    
}