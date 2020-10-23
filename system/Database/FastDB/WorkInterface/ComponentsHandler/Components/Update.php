<?php

namespace System\Database\FastDB\WorkInterface\ComponentsHandler\Components;

use GuzzleHttp\Client;

/**
 * Select
 */
class Update
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

        $client = new Client();

        foreach($this->selectData as $id => $data)
        {
            $response = $client->request('POST', 'http://mydb.loc'.$argc['url-request'], [
                'query' => [
                    'server'       => $this->connection->getFullServer(),
                    'login'        => $this->connection->getUsername(),
                    'password'     => $this->connection->getPassword(),
                    'dbname'       => $this->connection->getDbname(),
                    'table'        => $this->table,
                    'id'           => $id,
                    'connect-exit' => 'true',
                    'show-text'    => 'ok-show'
                ],
                'form_params' => array_combine($argc['columns'], $argc['values']),
                'allow_redirects' => false
            ]);
        }

    }

} 