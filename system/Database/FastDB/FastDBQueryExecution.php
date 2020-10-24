<?php

namespace System\Database\FastDB;

use System\Database\FastDB\FastDBConnected;
use System\Database\FastDB\HandleExecutionEmbed;
use System\Database\FastDB\HandleExecutionUpdate;
use System\Database\FastDB\Exception\InvalidTableException;
use System\Database\FastDB\HandleExecutionWhere as Where;
use FastDB\Commands\Handler\Commands;
use FastDB\Commands\ShowDataCommand;
use FastDB\Commands\DeleteDataCommand;
use FastDB\Commands\CountCommand;
use FastDB\Commands\JoinTablesCommand;
use FastDB\Commands\WriteDataCommand;
use FastDB\Commands\UpdateDataCommand;
use FastDB\Commands\ShowAllUsersCommand;
use FastDB\Commands\ShowDatabasesCommand;
use FastDB\Commands\ShowDeletedDataCommand;
use Store;
use Response;
use Request;
use Common;

/**
 * Class FastDBConnected
 * @package System\Database\FastDB
 */
class FastDBQueryExecution
{
    
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
     * @var string
     */
    private $table;

    /**
     * @var array
     */
    private $data = [];

    /**
     * @var object
     */
	private $executeObject;

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
    | -------------------------------------------------------------------------
    |  Соединение с FastDB(База данных): settings .ENV
    | -------------------------------------------------------------------------
     *
     * @param   array $connection
     * @param $server
     *
     * @return $this
     */
    public function connect(array $connection, $server):object
    {

        new FastDBConnected($connection, $server);

        $this->username = $connection['username'];
        $this->password = $connection['password'];
        $this->dbname = $connection['dbname'];
        $this->server = Store::replace([':' => '-'], $server);
        
        return $this;
        
    }

    /**
    | -------------------------------------------------------------------------
    |  Получает все БД подключеного пользователя: settings .ENV
    | -------------------------------------------------------------------------
     *
     * @return array
     */
    public function allDb():array
    {
        
        $listsDb = [];
        $list = Store::scan('FastDB/Server/'.$this->server.'/Databases/Database/'.$this->username);
        
        foreach($list as $db)
        {
            list($userPart, $dbPart) = explode('_', $db);
            list($databaseTitle, $dbFile) = explode('-', $dbPart);
            list($database, $file) = explode('.', $dbFile);
            
            $listsDb[] = $database;
        }
        
        return (array) [
            'ListDb' => $listsDb
        ];
        
    }
    
    /**
    | -------------------------------------------------------------------------
    |  Получает все таблицы БД указаной в настройках подключения: settings .ENV
    | -------------------------------------------------------------------------
     *
     * @return array
     */
    public function allTables():array
    {
        
        $fullListTables = [];
        $list = Store::scan('FastDB/Server/'.$this->server.'/Tables/Tables/'.$this->username);
        
        foreach($list as $tables)
        {
            if(strpos($tables, '.json') 
               && Store::isFile('FastDB/Server/'.$this->server.'/Tables/Tables/'.$this->username.'/'.$tables)) 
            {
                list($dbPart, $tablePart) = explode('_', $tables);
                list($contextDb, $contextTable) = explode('-', $tablePart);
                list($table, $file) = explode('.', $contextTable);
                
                $fullListTables[] = $table;
            }
        }
        
        return (array) [
            'ListTables' => $fullListTables
        ];
        
    }

    /**
    | -------------------------------------------------------------------------
    |  Получает все таблицы определеной БД $db_name
    | -------------------------------------------------------------------------
     *
     * @param $db_name
     *
     * @return array
     */
    public function otherTablesDb($db_name):array
    {
        
        $tables = [];
        
        if(Store::exists('FastDB/Server/'.$this->server.'/Databases/Database/'.$this->username.'/user='.$this->username.'&database='.$db_name.'.json'))
        {
            $list = Store::scan('FastDB/Server/'.$this->server.'/Tables/Tables/'.$this->username);
            
            foreach($list as $table)
            {
                
                if(strpos($table, 'database-'.$db_name.'_') !== false
                          && strpos($table, '.json') !== false)
                {
                    list($dbPart, $tablePart) = explode('_', $table);
                    list($contextDb, $contextTable) = explode('-', $tablePart);
                    list($table, $file) = explode('.', $contextTable);

                    $tables['db-'.$db_name][] = $table;
                }
            }
            
            return (array) $tables;
        }
        
        return [];
        
    }
	
    /**
     * Is Table
     *
     * @return bool
     */
    private function isTable():bool
    {
        
        return (Store::isDir('FastDB/Server/'.$this->server.'/Tables/Tables/'.$this->username.'/database='.$this->dbname.'&data&table='.$this->table)) ? 
            true : false;
        
    }

    /**
     * Table Name
     *
     * @param $table
     *
     * @return $this|object
     * @throws InvalidTableException
     */
    public function table($table):object
    {
        
        $this->table = $table;
        
        if($this->isTable() === false)
            throw new InvalidTableException($this->table, $this->dbname);
        
        return $this;
        
    }
	
	/**
     * ===========================================
     * Выполнить запрос в бд через команду
     * ===========================================
     */
	public function command($cmd)
	{

        $command = new Commands();

        $command->registration(new ShowDataCommand());
        $command->registration(new DeleteDataCommand());
        $command->registration(new CountCommand());
        $command->registration(new JoinTablesCommand());
        $command->registration(new WriteDataCommand());
        $command->registration(new UpdateDataCommand());
        $command->registration(new ShowAllUsersCommand());
        $command->registration(new ShowDatabasesCommand());
        $command->registration(new ShowDeletedDataCommand());
		
		return $command->executeCommand($cmd);
		
	}
        
    /**
     * showDatabasesWithTables
     *
     * @param  mixed $with
     * @return object
     */
    public function showDatabasesWithTables($with = 'DB'):object
    {

        $this->executeObject = 'System\\Database\\FastDB\\HandleExecutionShowDatabases';

        switch(up_line($with))
        {
            case 'DB': 
                $with = 'DB';
                break;
            case 'TABLES':
                $with = 'TABLES';
                break;
            default:
                $with = 'DB';
                break;
        }

        $this->paramsExecute['with'] = $with;
		
		return $this;

    }
    
    /**
     * showStorerDeletedData
     *
     * @return void
     */
    public function showStorerDeletedData()
    {

        $pathTablesDir = 'FastDB/Server/'.$this->server.'/Tables/Tables/%s/';
		$pathTablesDir = sprintf($pathTablesDir, $this->username);
		
		$structure = Store::getApi($pathTablesDir.'data-store.fd');
		$structure = Store::uncompress($structure);
		$structure = Response::jsonToArray($structure);

        $this->data = $structure[0];

        return $this;

    }
    
    /**
     * showAllUsers
     *
     * @return void
     */
    public function showAllUsers()
    {

        $this->executeObject = 'System\\Database\\FastDB\\HandleShowAllUsers';

        return $this;

    }

    /**
     * ===========================================
     * Выборка всех записей из бд
     * ===========================================
     *
     * @return $this|object
     */
	public function select():object
	{
		
		$pathTablesDir = 'FastDB/Server/'.$this->server.'/Tables/Tables/%s/database=%s&data&table=%s/';
		$pathTablesDir = sprintf($pathTablesDir, $this->username, $this->dbname, $this->table, $this->username);
		
		$structure = Store::getApi($pathTablesDir.'settings-data-table.json');
		$structure = Store::uncompress($structure);
		$structure = Response::jsonToArray($structure);
		
		$data = Store::getApi($pathTablesDir.'data.json');
		$data = Store::uncompress($data);
		$data = Response::jsonToArray($data);
		
		$params = (empty(func_get_args())) ? [0 => []] : func_get_args();
		
		$methodParams = (is_array($params[0])) ? $params[0] : $params;
		
		if(count($methodParams) > 0 && !empty($methodParams[0]))
		{
			foreach($methodParams as $field)
			{
				foreach($data[1] as $key => $dataArray)
				{	
					if(array_key_exists($field, $dataArray))
						$this->data[$key][$field] = $dataArray[$field];
				}
			}
		}
		else
            $this->data = $data[1];
		
		return $this;
		
	}

    /**
     * =================================
     *  Удаление записи из таблицы
     * =================================
     *
     * @return $this|object
     */
	public function delete():object
	{
		
		$this->select();
		
		$this->executeObject = 'System\\Database\\FastDB\\HandleExecutionDelete';
		
		return $this;
		
	}

    /**
     * ================================================
     *  Обновление записи в таблице
     * ================================================
     *
     * @param   array $fields
     * @param   array $values
     *
     * @return $this|object
     */
	public function update(array $fields, array $values):object
	{
		
		$this->select();
		
		$this->executeObject = 'System\\Database\\FastDB\\HandleExecutionUpdate';
		$this->paramsExecute['fields'] = $fields;
		$this->paramsExecute['values'] = $values;
		
		return $this;
		
	}

    /**
     * ==============================================
     *  Добавление записи в таблицу
     * ==============================================
     *
     * @param   array $fields
     * @param   array $values
     *
     * @return $this
     */
	public function embed(array $fields, array $values)
	{
		
		$this->executeObject = 'System\\Database\\FastDB\\HandleExecutionEmbed';
		$this->paramsExecute['fields'] = $fields;
		$this->paramsExecute['values'] = $values;
		
		return $this;
		
	}

    /**
     * =========================================================
     *  Выборка, обновление, удаление... Определеный записей
     * =========================================================
     *
     * @param $field
     * @param $as
     * @param $value
     *
     * @return $this|object
     */
	public function where($field, $as, $value):object
	{
		
		$whereHandle = new Where($this->data, $field, $as, $value);
		
		switch($as)
		{
			case '=':
				$this->data = $whereHandle->handle('whereEqually')->getData();
				break;
			case '!=':
				$this->data = $whereHandle->handle('whereNotEqual')->getData();
				break;
			case '>':
				$this->data = $whereHandle->handle('whereMore')->getData();
				break;
			case '<':
				$this->data = $whereHandle->handle('whereLess')->getData();
				break;
			case '>=': 
				$this->data = $whereHandle->handle('whereMoreEqual')->getData();
				break;
			case '<=':
				$this->data = $whereHandle->handle('whereLessEqual')->getData();
				break;
			case '<>':
				$this->data = $whereHandle->handle('whereLessMore')->getData();
				break;
			default:
				$this->data = $whereHandle->handle('whereEqually')->getData();
				
		}
		
		return $this;
		
	}

    /**
     * =======================================
     *  Подчитывает кол-во записей в запросе
     * =======================================
     *
     * @return int
     */
    public function count()
    {

		$this->select();
		
		$this->executeObject = 'System\\Database\\FastDB\\HandleExecutionCount';
		
        return $this;
        
    }

    /**
     * ============================================
     *  Вывести кол-во записей. Пример: с 2 по 5
     * ============================================
     *
     * @param   int $from
     * @param   int $before
     *
     * @return $this|object
     */
    public function limit(int $from = 1, int $before = 0):object
    {
        
		$from = $from === 0 ? 0 : $from - 1;

		$before = ($before == 0 || $before < $from) ? count($this->data) : $before - 1;

		$newData = [];
		$commonData = [];
		
		foreach($this->data as $data)
			$commonData[] = $data;
		
		for($i = $from; $i <= $before; $i++)
		{
			(array_key_exists($i, $commonData)) ? $newData[$i] = $commonData[$i] : false;
		}
		
		$this->data = $newData;
		
		return $this;
        
    }

    /**
     * ===================================
     *  Сортировка данных в таблице
     * ===================================
     *
     * @param $fields
     * @param   null $comparison
     *
     * @return $this|object
     */
    public function sort($fields, $comparison = null):object
    {
        
        $comparison = ($comparison != 'more' && $comparison != 'smaller') ? 
            'smaller' : 
        $comparison;
        
        $fullData = $this->data;
        
        uasort($fullData, function($a, $b) use ($fields, $comparison) {
            
            return ($comparison == 'more') ? 
                $a[$fields] < $b[$fields] : 
            $a[$fields] > $b[$fields];
            
        });
        
        $this->data = $fullData;
        
        return $this;
        
    }

    /**
     * =========================================================================
     *  Возврощает массив данных из таблицы, НЕ используется для countSelected
     * =========================================================================
     *
     * @return array
     */
    public function fetch():array
    {
        
       return $this->data;
        
    }

    /**
     * =====================================================
     *  Вызывается данный метод для update, delete, embed
     * =====================================================
     *
     * @return mixed
     */
	public function execute()
	{
		
		$objectExecute = new $this->executeObject($this->data, $this->table, $this->dbname, $this->username, $this->paramsExecute, $this->server);
		
		return $objectExecute->handle();
		
	}
    
}
