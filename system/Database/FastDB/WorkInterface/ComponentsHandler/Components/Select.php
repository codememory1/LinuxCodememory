<?php

namespace System\Database\FastDB\WorkInterface\ComponentsHandler\Components;

/**
 * Select
 */
class Select
{
        
    /**
     * table
     *
     * @var mixed
     */
    protected $table;
    
    /**
     * selectData
     *
     * @var array
     */
    protected $selectData = [];
    
    /**
     * connection
     *
     * @var mixed
     */
    protected $connection;

    /**
     * __construct
     *
     * @param  mixed $table
     * @param  mixed $argc
     * @param  mixed $selectData
     * @return void
     */
    public function __construct(string $table, array $selectData = [], $connection)
    {
        
        $this->table = $table;
        $this->selectData = $selectData;
        $this->connection = $connection;

    }
    
    /**
     * handler
     *
     * @param  mixed $argc
     * @return void
     */
    public function handler(array $argc = [])
    {

        $data = [];

        if(count($argc['columns']) > 0) {
            foreach($argc['columns'] as $column)
            {
                foreach($this->selectData as $key => $value)
                {
                    if(array_key_exists($column, $value)) {
                        $data[$key][$column] = $value[$column];
                    }
                }
            }

            return $data === [] ? $this->selectData : $data;
        } else {
            return $this->selectData;
        }

    }

} 