<?php

namespace System\Database\FastDB\WorkInterface;

use System\Database\FastDB\WorkInterface\Exceptions\InvalidRequestException;
use System\Database\FastDB\WorkInterface\ComponentsHandler\Flags\Where;
use System\Database\FastDB\WorkInterface\ComponentsHandler\Flags\Limit;
use System\Database\FastDB\WorkInterface\ComponentsHandler\Flags\SortNumbers;
use System\Database\FastDB\WorkInterface\ComponentsHandler\Flags\Condition;
use FastDB\ComponentsClasses\Commands\Handler\Commands;
use FastDB\ComponentsClasses\Commands\ShowDataCommand;
use FastDB\ComponentsClasses\Commands\CountCommand;
use FastDB\ComponentsClasses\Commands\DeleteDataCommand;
use FastDB\ComponentsClasses\Commands\JoinTablesCommand;
use FastDB\ComponentsClasses\Commands\WriteDataCommand;
use FastDB\ComponentsClasses\Commands\UpdateDataCommand;
use FastDB\ComponentsClasses\Commands\ShowAllUsersCommand;
use FastDB\ComponentsClasses\Commands\ShowDatabasesCommand;
use Store;
use Response;

/**
 * Components
 */
class Components
{
    
    const PATH_DB = 'FastDB/Servers/%s/%s';
    
    /**
     * tablename
     *
     * @var mixed
     */
    protected $tablename;
    
    /**
     * columns
     *
     * @var array
     */
    protected $columns = [];
    
    /**
     * values
     *
     * @var array
     */
    protected $values = [];
    
    /**
     * selectData
     *
     * @var array
     */
    protected $selectData = [];
    
    /**
     * methodAguments
     *
     * @var array
     */
    protected $methodAguments = [];
    
    /**
     * classHandler
     *
     * @var string
     */
    protected $classHandler;
    
    /**
     * connection
     *
     * @var Connection
     */
    protected $connection;
        
    /**
     * __construct
     *
     * @param  mixed $connection
     * @return void
     */
    public function __construct($connection)
    {
        
        $this->connection = $connection;

    }

    /**
     * getPathDb
     *
     * @param  mixed $server
     * @param  mixed $port
     * @param  mixed $username
     * @param  mixed $dbname
     * @return void
     */
    private function getPathDb(string $join = null):string
    {

        return sprintf(self::PATH_DB, $this->connection->getFullServer('-'), 'Databases/'.$this->connection->getUsername().'/database='.$this->connection->getDbname()).$join;

    }

    /**
     * data
     *
     * @return void
     */
    private function getDataTable(string $table):array
    {

        $path = $this->getPathDb();
        $pathTable = sprintf($path.'/Tables/table=%s/data.fd', $table);

        return Response::jsonToArray(Store::getApi($pathTable))['data'];

    }
    
    /**
     * query
     *
     * @param  mixed $cmd
     * @return void
     */
    public function query($cmd)
    {

        $command = new Commands($this);

        $command->registration(new ShowDataCommand($command->getQuery()));
        $command->registration(new DeleteDataCommand($command->getQuery()));
        $command->registration(new CountCommand());
        $command->registration(new JoinTablesCommand($command->getQuery()));
        $command->registration(new WriteDataCommand($command->getQuery()));
        $command->registration(new UpdateDataCommand($command->getQuery()));
        $command->registration(new ShowAllUsersCommand());
        $command->registration(new ShowDatabasesCommand());

        return $command->executeCommand($cmd);

    }

    /**
     * table
     *
     * @param  mixed $table
     * @return void
     */
    public function table(string $table)
    {

        if(!Store::isDir($this->getPathDb('/Tables/table='.$table))) {
            throw new InvalidRequestException();
        } else {
            $this->tablename = $table;
            $this->selectData = $this->getDataTable($this->tablename);
        }

        return $this;

    }
    
    /**
     * select
     *
     * @param  mixed $columns
     * @return void
     */
    public function select(array $columns = [])
    {

        $this->classHandler = 'System\Database\FastDB\WorkInterface\ComponentsHandler\Components\Select';
        $this->methodAguments['table'] = $this->tablename;
        $this->methodAguments['columns'] = $columns;

        return $this;

    }
    
    /**
     * columns
     *
     * @param  mixed $columns
     * @return void
     */
    public function columns(array $columns)
    {

        $this->columns = $columns;

        return $this;

    }
    
    /**
     * values
     *
     * @param  mixed $values
     * @return void
     */
    public function values(array $values)
    {

        $this->values = $values;

        return $this;

    }
        
    /**
     * arguments
     *
     * @param  mixed $namespace
     * @param  mixed $url
     * @return void
     */
    private function arguments(string $namespace, string $url)
    {

        $this->classHandler = $namespace;
        $this->methodAguments['url-request'] = $url;
        $this->methodAguments['columns'] = $this->columns;
        $this->methodAguments['values'] = $this->values;

    }

    /**
     * embed
     *
     * @param  mixed $table
     * @return void
     */
    public function embed()
    {

        $this->arguments('System\Database\FastDB\WorkInterface\ComponentsHandler\Components\Embed', '/fastdb/table/embed/handler');

        return $this;

    }
    
    /**
     * update
     *
     * @return void
     */
    public function update()
    {

        $this->arguments('System\Database\FastDB\WorkInterface\ComponentsHandler\Components\Update', '/fastdb/table/edit/data/handler');

        return $this;

    }
    
    /**
     * delete
     *
     * @return void
     */
    public function delete()
    {

        $this->classHandler = 'System\Database\FastDB\WorkInterface\ComponentsHandler\Components\Delete';
        $this->methodAguments['url-request'] = '/fastdb/table/delete/selection';

        return $this;

    }

    public function count()
    {



    }
    
    /**
     * where
     *
     * @param  mixed $column
     * @param  mixed $separator
     * @param  mixed $value
     * @return void
     */
    public function where(string $column, string $separator, $value)
    {

        $separators = [
            '='  => 'equal',
            '!=' => 'notEqual',
            '>'  => 'more',
            '<'  => 'less',
            '>=' => 'moreEquals',
            '<=' => 'lessEquals',
            '<>' => 'lessMore'
        ];
        
        $flagWhere = new Where($this->selectData);

        if(array_key_exists($separator, $separators)) {
            $this->selectData = $flagWhere->handler($column, $separator, $separators[$separator], $value);
        } else {
            $this->selectData = $flagWhere->handler($column, '=', $separators['='], $value);
        }

        return $this;

    }
    
    /**
     * limit
     *
     * @param  mixed $from
     * @param  mixed $before
     * @return void
     */
    public function limit(int $from, int $before = -1)
    {

        $flagLimit = new Limit($this->selectData);

        $this->selectData = $flagLimit->handler($from, $before);

        return $this;

    }
        
    /**
     * condition
     *
     * @param  mixed $column
     * @param  mixed $regex
     * @param  mixed $flags
     * @param  mixed $condition
     * @return void
     */
    private function condition(string $column, string $regex, ?string $flags = null, ?string $condition = null)
    {

        $flagLimit = new Condition($this->selectData);
        
        $this->selectData = $flagLimit->handler($column, $regex, $flags, $condition);

    }

    /**
     * conditionIf
     *
     * @param  mixed $column
     * @param  mixed $regex
     * @return void
     */
    public function conditionIf(string $column, string $regex, ?string $flags = null)
    {

        $this->condition($column, $regex, $flags, 'if');

        return $this;

    }

    /**
     * conditionIf
     *
     * @param  mixed $column
     * @param  mixed $regex
     * @return void
     */
    public function conditionNotIf(string $column, string $regex, ?string $flags = null)
    {
echo '123';
        $this->condition($column, $regex, $flags, 'notIf');

        return $this;

    }
    
    /**
     * sortByNumbers
     *
     * @param  mixed $column
     * @param  mixed $as
     * @return void
     */
    public function sortByNumbers(string $column, string $as = 'less')
    {

        $flagLimit = new SortNumbers($this->selectData);

        $this->selectData = $flagLimit->handler($column, $as);

        return $this;

    }
    
    /**
     * fetch
     *
     * @return void
     */
    public function fetch()
    {

        $this->selectData = $this->exec(); 

        return $this->selectData;

    }
    
    /**
     * exec
     *
     * @return void
     */
    public function exec()
    {

        $classHandler = new $this->classHandler($this->tablename, $this->selectData, $this->connection);

        return $classHandler->handler($this->methodAguments);

    }

}