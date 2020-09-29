<?php

namespace System\Database\FastDB\FunctionalDatabase\Migration\ComponentsMigration;

/**
 * ServerCreation
 */
class ServerCreation
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
     * params
     *
     * @var mixed
     */
    private $params;
    
    
    /**
     * __construct
     *
     * @param  mixed $server
     * @param  mixed $fromServer
     * @param  mixed $params
     * @return void
     */
    public function __construct($server, $fromServer, array $params)
    {

        $this->server = $server;
        $this->fromServer = $fromServer;
        $this->params = $params;

    }
    
    /**
     * process
     *
     * @return void
     */
    public function process()
    {

        $handlerUri = $this->server->serverUri('users/create-server/handle');

        $params = [
            'server-ip'   => $this->params['server-ip'],
            'server-port' => $this->params['server-port']
        ];

        $request = curl_init($handlerUri);
        curl_setopt($request, CURLOPT_DEFAULT_PROTOCOL, $this->server->protocol());
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_POST, true);
		curl_setopt($request, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
        
        $result = curl_exec($request);
        curl_close($request);

    }

}