<?php

namespace System\Database\FastDB\WorkInterface\ComponentsHandler\Migration\Handlers;

use GuzzleHttp\Exception\ClientException;

/**
 * CreateTable
 */
class CreateDatabase
{
        
    /**
     * urlHandler
     *
     * @var string
     */
    private $urlHandler = 'http://mydb.loc/fastdb/db/create/handler';

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

        try {
            $response = $this->client->request('POST', $this->urlHandler, [
                'query'           => $this->interface->renderQuery(),
                'form_params'     => [
                    'db-name' => $args['nameCreatDb'],
                    'charset' => $args['charset'] ?? 'utf-8'
                ],
                'allow_redirects' => false
            ]);
    
            $this->interface->setLogging('Создание Базы Данных', $response, $this->interface);
    
            return true;
        } catch(ClientException $e) {
            return $this->interface->getResponseCode($e->getResponse()->getStatusCode());
        }

    }

}