<?php

namespace System\Database\FastDB\FunctionalDatabase\Migration;

use System\Database\FastDB\FunctionalDatabase\Migration\ServerConnections;

/**
 * MigrationComponentHandler
 */
class MigrationComponentHandler
{
    
    /**
     * server
     *
     * @var mixed
     */
    private $server;
    
    /**
     * fromServer
     *
     * @var mixed
     */
    private $fromServer;
    
    /**
     * componentClass
     *
     * @var mixed
     */
    private $componentClass;
    
    /**
     * paramsComponent
     *
     * @var mixed
     */
    private $paramsComponent;
    
    /**
     * fields
     *
     * @var array
     */
    private $fields = [];
    
    /**
     * connect
     *
     * @param  mixed $server
     * @param  mixed $username
     * @param  mixed $password
     * @param  mixed $dbname
     * @return void
     */
    public function connect($server = null, $dbname = null, $username = null)
    {

        $serverConnect = new ServerConnections();
        $serverConnect->connect();

        $this->paramsComponent['dbname'] = $dbname;
        $this->paramsComponent['server'] = $server;
        $this->paramsComponent['username'] = $username;

        $this->server = $serverConnect;

        return $this;

    }
    
    /**
     * fromConnect
     *
     * @param  mixed $server
     * @param  mixed $username
     * @param  mixed $password
     * @return void
     */
    public function fromConnect()
    {

        $this->server->fromConnect();

        return $this;

    }
    
    /**
     * createDatabase
     *
     * @param  mixed $dbname
     * @return void
     */
    public function createDatabase($dbname)
    {

        $this->componentClass = 'System\Database\FastDB\FunctionalDatabase\Migration\ComponentsMigration\DatabaseCreation';
        $this->paramsComponent['dbname'] = $dbname;

        return $this;

    }
    
    /**
     * databaseDrop
     *
     * @param  mixed $dbname
     * @return void
     */
    public function removeDatabase($dbname)
    {

        $this->componentClass = 'System\Database\FastDB\FunctionalDatabase\Migration\ComponentsMigration\DatabaseDrop';
        $this->paramsComponent['dbname'] = $dbname;

        return $this;

    }
    
    /**
     * charsetDb
     *
     * @param  mixed $charset
     * @return void
     */
    public function charsetDb($charset)
    {

        $this->paramsComponent['charset-db'] = $charset;

        return $this;

    }
    
    /**
     * presentationCreate
     *
     * @param  mixed $name
     * @return void
     */
    public function createPresent($name)
    {

        $this->componentClass = 'System\Database\FastDB\FunctionalDatabase\Migration\ComponentsMigration\PresentationCreation';
        $this->paramsComponent['present-name'] = $name;

        return $this;

    }
    
    /**
     * presentEvent
     *
     * @param  mixed $event
     * @return void
     */
    public function presentEvent($event)
    {

        $this->paramsComponent['present-event'] = $event;

        return $this;

    }
    
    /**
     * presentOn
     *
     * @param  mixed $dbname
     * @param  mixed $table
     * @return void
     */
    public function presentOn($dbname, $table)
    {

        $this->paramsComponent['present-dbname'] = $dbname;
        $this->paramsComponent['present-table'] = $table;

        return $this;
        
    }
    
    /**
     * presentHandler
     *
     * @param  mixed $url
     * @param  mixed $method
     * @param  mixed $requests
     * @return void
     */
    public function presentHandler($url, $method = 'GET', $requests = 1)
    {

        $this->paramsComponent['present-url'] = $url;
        $this->paramsComponent['present-method'] = $method;
        $this->paramsComponent['present-requests'] = $requests;

        return $this;

    }
    
    /**
     * presentDrop
     *
     * @param  mixed $name
     * @return void
     */
    public function removePresent($name)
    {

        $this->componentClass = 'System\Database\FastDB\FunctionalDatabase\Migration\ComponentsMigration\PresentationDrop';
        $this->paramsComponent['present-name'] = $name;

        return $this;

    }
    
    /**
     * serverCreate
     *
     * @return void
     */
    public function createServer()
    {

        $this->componentClass = 'System\Database\FastDB\FunctionalDatabase\Migration\ComponentsMigration\ServerCreation';

        return $this;

    }
    
    /**
     * ipServer
     *
     * @param  mixed $ip
     * @return void
     */
    public function ipServer($ip)
    {

        $this->paramsComponent['server-ip'] = $ip;

        return $this;

    }
        
    /**
     * portServer
     *
     * @param  mixed $port
     * @return void
     */
    public function portServer($port)
    {

        $this->paramsComponent['server-port'] = $port;

        return $this;

    }
    
    /**
     * table
     *
     * @param  mixed $tableName
     * @return void
     */
    public function table($tableName)
    {

        $this->paramsComponent['table-name'] = $tableName;

        return $this;

    }
    
    /**
     * database
     *
     * @param  mixed $dbname
     * @return void
     */
    public function database($dbname)
    {

        $this->paramsComponent['dbname'] = $tableName;

        return $this;

    }

    /**
     * tableCreate
     *
     * @param  mixed $tableName
     * @return void
     */
    public function createTable()
    {

        $this->componentClass = 'System\Database\FastDB\FunctionalDatabase\Migration\ComponentsMigration\TableCreation';

        return $this;

    }
    
    /**
     * field
     *
     * @param  mixed $field
     * @param  mixed $dataField
     * @return void
     */
    public function field($field, callable $dataField)
    {

        call_user_func($dataField);

        $this->paramsComponent['field-name'] = $field;
        $this->paramsComponent['data-fields'][$field] = $this->fields;

        $this->fields = [];

        return $this;

    }
    
    /**
     * type
     *
     * @param  mixed $type
     * @return void
     */
    public function type($type):void
    {

        $this->fields['type'][] = $type;

    }
    
    /**
     * length
     *
     * @param  mixed $length
     * @return void
     */
    public function length($length):void
    {

        $this->fields['length'][] = $length;

    }
    
    /**
     * default
     *
     * @param  mixed $default
     * @return void
     */
    public function default($default):void
    {

        $this->fields['default'][] = $default;

    }
    
    /**
     * hisDefault
     *
     * @param  mixed $his
     * @return void
     */
    public function hisDefault($his):void
	{
		
		$this->fields['hisDefault'][] = $his;
		
    }
        
    /**
     * charset
     *
     * @param  mixed $charset
     * @return void
     */
    public function charset($charset):void
    {

        $this->fields['charset'][] = $charset;

    }
    
    /**
     * tableDrop
     *
     * @return void
     */
    public function removeTable()
    {

        $this->componentClass = 'System\Database\FastDB\FunctionalDatabase\Migration\ComponentsMigration\TableDrop';

        return $this;

    }
    
    /**
     * updateStructure
     *
     * @return void
     */
    public function updateStructure()
    {

        $this->componentClass = 'System\Database\FastDB\FunctionalDatabase\Migration\ComponentsMigration\UpdateStructureTable';

        return $this;

    }
    
    /**
     * createUser
     *
     * @return void
     */
    public function createUser()
    {

        $this->componentClass = 'System\Database\FastDB\FunctionalDatabase\Migration\ComponentsMigration\UserCreation';

        $this->paramsComponent['save-deleted-data'] = 0;
        $this->paramsComponent['notification'] = 'false';

        return $this;

    }
    
    /**
     * username
     *
     * @param  mixed $username
     * @return void
     */
    public function username($username)
    {

        $this->paramsComponent['login-create'] = $username;

        return $this;

    }
    
    /**
     * password
     *
     * @param  mixed $password
     * @return void
     */
    public function password($password)
    {

        $this->paramsComponent['password-create'] = $password;

        return $this;

    }
    
    /**
     * notification
     *
     * @param  mixed $status
     * @return void
     */
    public function notification($status = false)
    {

        $this->paramsComponent['notification'] = $status === true ? 'true' : 'false';

        return $this;

    }
    
    /**
     * saveDeletedData
     *
     * @param  mixed $status
     * @return void
     */
    public function saveDeletedData($status = false)
    {

        $this->paramsComponent['save-deleted-data'] = $status === true ? 'true' : 0;

        return $this;

    }
    
    /**
     * perk
     *
     * @param  mixed $perk
     * @param  mixed $status
     * @return void
     */
    public function perk($perk, bool $status = true)
	{
		
		$this->paramsComponent['perk']['rights_'.$perk] = $status;
		
		return $this;
		
    }
        
    /**
     * userDrop
     *
     * @return void
     */
    public function removeUser()
    {

        $this->componentClass = 'System\Database\FastDB\FunctionalDatabase\Migration\ComponentsMigration\UserDrop';

        return $this;

    }
    
    /**
     * editUser
     *
     * @return void
     */
    public function editUser($user)
    {

        $this->componentClass = 'System\Database\FastDB\FunctionalDatabase\Migration\ComponentsMigration\UpdateSettingsUser';

        $this->paramsComponent['login'] = $user;

        return $this;

    }
    
    /**
     * updatePrivilege
     *
     * @return void
     */
    public function updatePrivilege()
    {

        $this->componentClass = 'System\Database\FastDB\FunctionalDatabase\Migration\ComponentsMigration\UpdatePrivilegeUser';

        return $this;

    }

    /**
     * execute
     *
     * @return void
     */
    public function execute()
    {

        $class = new $this->componentClass($this->server, $this->fromServer, $this->paramsComponent);
        $class->process();

    }

}