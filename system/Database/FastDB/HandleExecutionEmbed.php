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
class HandleExecutionEmbed
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
		
		return $this->embed($this->paramsExecute['fields'], $this->paramsExecute['values']);
		
	}

    /**
     * Метод который получает именя полей в таблице
     *
     * @return array
     */
	private function getStructure():array
	{
		
		$pathTablesDir = 'FastDB/Server/'.$this->server.'/Tables/Tables/%s/database=%s&data&table=%s/';
		$pathTablesDir = sprintf($pathTablesDir, $this->username, $this->dbname, $this->table, $this->username);
		
		$structure = Store::getApi($pathTablesDir.'data.json');
		$structure = Store::uncompress($structure);
		$structure = Response::jsonToArray($structure);
		
		return $structure;
		
	}

    /**
     * Метод который добавляет запись в таблицу
     *
     * @param   array $fields
     * @param   array $values
     */
	public function embed(array $fields, array $values)
	{
		
		foreach($this->getStructure()[0][0] as $fieldStructure)
		{
			
			if(!array_key_exists($fieldStructure, array_combine($fields, $fields)))
				$fields[] = $fieldStructure;
			
		}
		
		$postParams = [];
		
		foreach($fields as $key => $field)
		{
			
			if(!array_key_exists($field, $this->getStructure()[0][0]))
			{
				unset($fields[$key]);
				unset($values[$key]);
			}
			
			if(!array_key_exists($key, $values))
				$values[$key] = '';
			
		}
		
		foreach($fields as $key => $field)
		{
			
			$postParams[$field] = $values[$key];
			
		}
		
		$curl = new CurlRequest();

		$respnce = $curl->init(
			Env::get('APP_URL').
			route('FastDB.add-data-table-handle', ['db' => $this->dbname, 'table' => $this->table]).
			Common::collectParameters(['username' => $this->username, 'server' => $this->server])
		)
		->method('POST')
		->setOpt(CURLOPT_POSTFIELDS, $postParams)
		->response();

		// $sendCurl = Request::send(
		// 	Env::get('APP_URL').
		// 	route('FastDB.add-data-table-handle', ['db' => $this->dbname, 'table' => $this->table]).
		// 	Common::collectParameters(['username' => $this->username, 'server' => $this->server])
		// );
		// $option = $sendCurl
		// 	->option(CURLOPT_POST, true)
		// 	->option(CURLOPT_POSTFIELDS, $postParams);
		// $reply = $option->reply();
		// $close = $reply->close();
		
	}
    
}