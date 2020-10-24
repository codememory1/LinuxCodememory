<?php

namespace System\Database\FastDB\WorkInterface\ComponentsHandler\Migration\Handlers;

use GuzzleHttp\Exception\ClientException;

/**
 * CreateTable
 */
class CreateTable
{
        
    /**
     * urlHandler
     *
     * @var string
     */
    private $urlHandler = 'http://192.168.0.111/fastdb/table/create/handler';

    /**
     * dbname
     *
     * @var string
     */
    private $dbname;
    
    /**
     * tablename
     *
     * @var string
     */
    private $tablename;
    
    /**
     * interface
     *
     * @var mixed
     */
    private $interface;
    
    /**
     * client
     *
     * @var mixed
     */
    private $client;
    
    /**
     * __construct
     *
     * @param  mixed $dbname
     * @param  mixed $tablename
     * @return void
     */
    public function __construct(?string $dbname = null, ?string $tablename = null, $interface, $client)
    {

        $this->dbname = $dbname;
        $this->tablename = $tablename;
        $this->interface = $interface;
        $this->client = $client;

    }
    
    /**
     * main
     *
     * @param  mixed $args
     * @return void
     */
    public function main(array $args)
    {

        $columns = [
            'table-name'      => $args['nameCreatTable'],
            'add-column-life' => $args['columns']['add-column-life'] ?? 'off',
            'name-column'     => [],
            'type'            => [],
            'length'          => [],
            'default'         => [],
            'other-default'   => [],
            'charset'         => []
        ];

        foreach($args['columns'] as $key => $column)
        {
            if(is_array($column)) {
                foreach($column as $key => $value) {
                    if(array_key_exists($key, $columns)) {
                        $columns[$key][] = $value;
                    }
                }
            }
        }

        try {
            $response = $this->client->request('POST', $this->urlHandler, [
                'query'           => $this->interface->renderQuery(['dbname' => $this->dbname]),
                'form_params'     => $columns,
                'allow_redirects' => false
            ]);
    
            $this->interface->setLogging('Создание Таблицы', $response, $this->interface);

            return true;
        } catch(ClientException $e) {
            return $this->interface->getResponseCode($e->getResponse()->getStatusCode());
        }

    }

}