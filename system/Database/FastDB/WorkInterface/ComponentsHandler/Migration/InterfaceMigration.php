<?php

namespace System\Database\FastDB\WorkInterface\ComponentsHandler\Migration;

use System\Database\FastDB\WorkInterface\ComponentsHandler\Migration\ {
    Connect,
    Handlers\CreateTable,
    Handlers\CreateDatabase,
    Handlers\DropDatabase,
    Handlers\CreateUser,
    Handlers\DropTable,
    Handlers\ClearTable,
    Handlers\ChangeTableSettings,
    Handlers\UpdateTokenUser,
    Handlers\ChangeUserSettings,
    Handlers\DeleteUser,
    Handlers\EditUserPrivilege,
    ExecuteSettingsXml,
    MigrationTraits\SettingsCreateTableTrait,
    MigrationTraits\SettingsUserDataTrait,
    MigrationTraits\ChangeTableSettingsTrait,
    MigrationTraits\HandlerLoggingTrait,
    MigrationInterfaces\ErrorRequestInterface
};
use GuzzleHttp\Client;

/**
 * InterfaceMigration
 */
class InterfaceMigration implements ErrorRequestInterface
{

    use SettingsCreateTableTrait, SettingsUserDataTrait, ChangeTableSettingsTrait, HandlerLoggingTrait;
    
    /**
     * connection
     *
     * @var mixed
     */
    public $connection;

    /**
     * dbname
     *
     * @var string
     */
    protected $dbname;
    
    /**
     * tablename
     *
     * @var string
     */
    protected $tablename;
    
    /**
     * arguments
     *
     * @var array
     */
    private $arguments = [];
    
    /**
     * classHandler
     *
     * @var object
     */
    private $classHandler;
    
    /**
     * columnsTable
     *
     * @var array
     */
    public $columnsTable = [];
        
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {

        $this->connection = new Connect();
        $this->execSettings = new ExecuteSettingsXml($this->connection);

    }

    /**
     * renderQuery
     *
     * @param  mixed $addet
     * @return array
     */
    public function renderQuery(array $addet = []):array
    {

        $query = [
            'server'       => sprintf('%s:%s', $this->connection->getServer(), $this->connection->getPort()),
            'login-auth'   => (string) $this->connection->getUsername(),
            'password'     => (string) $this->connection->getPassword(),
            'connect-exit' => 'true',
            'show-text'    => 'ok-show'
        ];

        if($addet !== []) {
            foreach($addet as $key => $value) $query[$key] = $value;
        }

        return $query;

    }

    /**
     * setArgument
     *
     * @param  mixed $key
     * @param  mixed $value
     * @return void
     */
    private function setArgument(string $key, $value)
    {

        $this->arguments[$key] = $value;

        return $this;

    }
    
    /**
     * table
     *
     * @param  mixed $table
     * @return void
     */
    public function table(string $table)
    {

        $this->tablename = $table;

        return $this;

    }
    
    /**
     * dbname
     *
     * @param  mixed $dbname
     * @return void
     */
    public function dbname(string $dbname)
    {

        $this->dbname = $dbname;

        return $this;

    }
    
    /**
     * createDatabase
     *
     * @param  mixed $dbname
     * @param  mixed $settings
     * @return void
     */
    public function createDatabase(string $dbname, callable $settings)
    {

        $this->setArgument('nameCreatDb', $dbname);
        $this->classHandler = CreateDatabase::class;

        call_user_func_array($settings, [$this]);

        return $this;
        
    }
    
    /**
     * createTable
     *
     * @param  mixed $tablename
     * @param  mixed $settings
     * @return void
     */
    public function createTable(string $tablename, callable $settings)
    {
        
        $this->setArgument('nameCreatTable', $tablename);
        $this->classHandler = CreateTable::class;

        call_user_func_array($settings, [$this]);

        $this->setArgument('columns', $this->columnsTable);

        return $this;

    }
    
    /**
     * createUser
     *
     * @param  mixed $username
     * @param  mixed $userdata
     * @return void
     */
    public function createUser(string $username, callable $userdata)
    {

        $this->classHandler = CreateUser::class;

        $this->userSettings['username'] = $username;
        call_user_func_array($userdata, [$this]);

        $this->setArgument('userdata', $this->userSettings);

        return $this;

    }
    
    /**
     * dropDatabase
     *
     * @return void
     */
    public function dropDatabase()
    {

        $this->classHandler = DropDatabase::class;

        return $this;

    }
    
    /**
     * dropTable
     *
     * @return void
     */
    public function dropTable()
    {

        $this->classHandler = DropTable::class;

        return $this;

    }
    
    /**
     * clearTable
     *
     * @return void
     */
    public function clearTable()
    {

        $this->classHandler = ClearTable::class;

        return $this;

    }
    
    /**
     * changeTableSettings
     *
     * @param  mixed $settings
     * @return void
     */
    public function changeTableSettings(callable $settings)
    {

        $this->classHandler = ChangeTableSettings::class;
        
        call_user_func_array($settings, [$this]);

        $this->setArgument('dbnameWhenMoving', $this->dbnameWhenMoving ?: $this->dbname);
        $this->setArgument('newTableName', $this->newTableName ?: $this->tablename);

        return $this;

    }
    
    /**
     * changeActiveUserSettings
     *
     * @param  mixed $userdata
     * @return void
     */
    public function changeActiveUserSettings(callable $userdata)
    {

        call_user_func_array($userdata, [$this]);

        $this->setArgument('userdata', $this->userSettings);

        $this->classHandler = ChangeUserSettings::class;

        return $this;

    }
    
    /**
     * changeUserSettings
     *
     * @param  mixed $username
     * @param  mixed $userdata
     * @return void
     */
    public function changeUserSettings(string $username, callable $userdata)
    {

        $this->setArgument('userEdit', $username);

        call_user_func_array($userdata, [$this]);

        $this->setArgument('userdata', $this->userSettings);

        $this->classHandler = ChangeUserSettings::class;

        return $this;

    }
    
    /**
     * updateTokenActiveUser
     *
     * @return void
     */
    public function updateTokenActiveUser()
    {

        $this->classHandler = UpdateTokenUser::class;
        
        return $this;

    }
    
    /**
     * deleteUser
     *
     * @param  mixed $username
     * @return void
     */
    public function deleteUser()
    {

        $this->setArgument('username', $this->userSettings['username']);

        $this->classHandler = DeleteUser::class;

        return $this;
        
    }
    
    /**
     * editPrivileges
     *
     * @param  mixed $privileges
     * @return void
     */
    public function editPrivileges(callable $privileges)
    {

        $this->setArgument('username', $this->userSettings['username']);

        call_user_func_array($privileges, [$this]);

        $this->setArgument('privilege', $this->userSettings['privilege']);

        $this->classHandler = EditUserPrivilege::class;

        return $this;

    }

    public function exec()
    {

        $handler  = new $this->classHandler($this->dbname, $this->tablename, $this, new Client());

        return $handler->main($this->arguments);

    }


}
