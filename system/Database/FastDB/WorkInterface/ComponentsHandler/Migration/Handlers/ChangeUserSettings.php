<?php

namespace System\Database\FastDB\WorkInterface\ComponentsHandler\Migration\Handlers;

use GuzzleHttp\Exception\ClientException;

/**
 * CreateTable
 */
class ChangeUserSettings
{
        
    /**
     * urlHandler
     *
     * @var string
     */
    private $urlHandler = 'http://mydb.loc/fastdb/users/create/handler';

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

        if(isset($args['userEdit'])) {
            try {
                $response = $this->client->request('POST', 'http://mydb.loc/fastdb/users/edit/handler', [
                    'query'           => $this->interface->renderQuery(['login' => $args['userEdit']]),
                    'form_params'     => $args['userdata'],
                    'allow_redirects' => false
                ]);

                echo $response->getBody();
        
                $this->interface->setLogging(sprintf('Изминение Настроек пользователя %s', $args['userEdit']), $response, $this->interface);
        
                return true;
            } catch(ClientException $e) {
                return $this->interface->getResponseCode($e->getResponse()->getStatusCode());
            }
        } else {
            try {
                $userdata = array_diff_key($args['userdata'], array_flip(['username', 'privilege', 'max-memory', 'freeze-account']));
                $response = $this->client->request('POST', 'http://mydb.loc/fastdb/settings/save', [
                    'query'           => $this->interface->renderQuery(),
                    'form_params'     => $userdata,
                    'allow_redirects' => false
                ]);
        
                $this->interface->setLogging('Изминение Настроек авторизированого пользователя', $response, $this->interface);

                return true;
            } catch(ClientException $e) {
                return $this->interface->getResponseCode($e->getResponse()->getStatusCode());
            }
        }

    }

}