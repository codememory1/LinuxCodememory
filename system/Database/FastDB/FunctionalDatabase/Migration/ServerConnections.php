<?php

namespace System\Database\FastDB\FunctionalDatabase\Migration;

use System\Database\Fastdb\FunctionalDatabase\Migration\Configuration;

/**
 * ServerConnections
 */
class ServerConnections
{
    
    const PROTOCOL = 'http';

    const SERVERURI = 'myDb.loc/fastdb/';

    /**
     * generateServer
     *
     * @var mixed
     */
    private $generateServer;
    
    /**
     * server
     *
     * @var mixed
     */
    public $server;
    
    /**
     * username
     *
     * @var mixed
     */
    public $username;
    
    /**
     * password
     *
     * @var mixed
     */
    public $password;
    
    /**
     * dbname
     *
     * @var mixed
     */
    public $dbname;
        
    /**
     * request
     *
     * @param  mixed $server
     * @param  mixed $user
     * @param  mixed $password
     * @return void
     */
    private function request($server, $user, $password)
    {

        $password = ($password == 'null' || empty($password) || $password === null) ? 'null' : $password;

        $curl = curl_init(self::SERVERURI.'existence-user/'.$server.'/'.$user.'/'.$password);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_DEFAULT_PROTOCOL, self::PROTOCOL);
        $reply = curl_exec($curl);
        curl_close($curl);

        return $reply;

    }

    /**
     * connect
     *
     * @param  mixed $server
     * @param  mixed $username
     * @param  mixed $password
     * @param  mixed $dbname
     * @return void
     */
    public function connect()
    {

        $conf = new Configuration();
        $open = $conf->open();

        $resultRequest = $this->request($open->getData('autification.server'), $open->getData('autification.login'), $open->getData('autification.password'));

        if($resultRequest !== 'OK')
        {
            exit($resultRequest);
        }

        $generate = '?'.
            'server='.$open->getData('autification.server').'&'.
            'username='.$open->getData('autification.login');

        $this->server = $open->getData('autification.server');
        $this->username = $open->getData('autification.login');
        $this->dbname = $open->getData('autification.dbname');
        $this->generateServer = $generate;

    }
    
    /**
     * fromConnect
     *
     * @return void
     */
    public function fromConnect()
    {

        $conf = new Configuration();
        $open = $conf->open();

        $resultRequest = $this->request($open->getData('autification-request.server'), $open->getData('autification-request.login'), $open->getData('autification-request.password'));

        if($resultRequest !== 'OK')
        {
            exit($resultRequest);
        }

        $this->generateServer .= '&fromServer='.str_replace(':', '-', $open->getData('autification-request.server')).'&fromUsername='.$open->getData('autification-request.login');

    }
    
    /**
     * serverUri
     *
     * @param  mixed $handler
     * @return void
     */
    public function serverUri($handler, $getParams = null)
    {

        return $this->getServerUrl().$handler.$this->generateServer.$getParams;

    }
    
    /**
     * getServerUrl
     *
     * @return void
     */
    public function getServerUrl()
    {

        return self::SERVERURI;

    }

    /**
     * getProtocol
     *
     * @return void
     */
    public function protocol()
    {

        return self::PROTOCOL;

    }
    
}