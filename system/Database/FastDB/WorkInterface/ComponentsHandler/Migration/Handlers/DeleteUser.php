<?php

namespace System\Database\FastDB\WorkInterface\ComponentsHandler\Migration\Handlers;

use GuzzleHttp\Exception\ClientException;

/**
 * CreateTable
 */
class DeleteUser
{
        
    /**
     * urlHandler
     *
     * @var string
     */
    private $urlHandler = 'http://mydb.loc/fastdb/users/delete';

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
            $response = $this->client->request('GET', $this->urlHandler, [
                'query'           => $this->interface->renderQuery(['login' => $args['username']]),
                'allow_redirects' => false
            ]);
            
            $this->interface->setLogging(sprintf('Удаление пользователя %s', $args['username']), $response, $this->interface);

            return true;
        } catch(ClientException $e) {
            return $this->interface->getResponseCode($e->getResponse()->getStatusCode());
        }

    }

}