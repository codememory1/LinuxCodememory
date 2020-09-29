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
class HandleExecutionUpdate
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
		
		return $this->update($this->paramsExecute['fields'], $this->paramsExecute['values']);
		
	}

    /**
     * Метод который получает именя полей в таблице
     *
     * @return array
     */
	private function getStructure():array
	{
		
		$pathTablesDir = 'FastDB/Server/'.$this->server.'/Tables/Tables/%s/database-%s_data_table-%s/';
		$pathTablesDir = sprintf($pathTablesDir, $this->username, $this->dbname, $this->table, $this->username);
		
		$structure = Store::getApi($pathTablesDir.'data.json');
		$structure = Response::jsonToArray($structure);
		
		return $structure;
		
	}

    /**
     * Метод который обновляет запись в таблице
     *
     * @param   array $fields
     * @param   array $values
     */
	private function update(array $fields, array $values)
	{
		

		foreach($this->data as $key => $dataArray)
		{
			
			foreach($fields as $k => $field)
			{
				
				if(!array_key_exists($k, $values))
					$values[$k] = '';
				
				$this->data[$key][$field] = $values[$k];
				
			}
			
		}
		
		foreach($this->data as $key => $dataArray)
		{
			
			$paramsPost = null;
			
			foreach($dataArray as $field => $valueField)
			{
				$paramsPost .= $field.'='.$valueField.'&';
			}
			
			$paramsPost = substr($paramsPost, 0, -1);
			
			$curl = new CurlRequest();

			$curl->init(
				Env::get('APP_URL').
				route('FastDB.edit-data-handle', ['db' => $this->dbname, 'table' => $this->table, 'id' => $key, 'where' => 'form']).
				Common::collectParameters(['username' => $this->username, 'server' => $this->server])
			)
			->method('POST')
			->setOpt(CURLOPT_POSTFIELDS, $paramsPost)
			->response();

			// $sendCurl = Request::send(
			// 	Env::get('APP_URL').
			// 	route('FastDB.edit-data-handle', ['db' => $this->dbname, 'table' => $this->table, 'id' => $key, 'where' => 'form']).
			// 	Common::collectParameters(['username' => $this->username, 'server' => $this->server])
			// );
			// $option = $sendCurl
			// 	->option(CURLOPT_POST, true)
			// 	->option(CURLOPT_POSTFIELDS, $paramsPost);
			// $reply = $option->reply();
			// $close = $reply->close();
			
		}
		
	}
    
}