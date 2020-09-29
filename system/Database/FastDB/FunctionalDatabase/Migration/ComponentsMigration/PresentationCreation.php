<?php

namespace System\Database\FastDB\FunctionalDatabase\Migration\ComponentsMigration;

class PresentationCreation
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

        $handlerUri = $this->server->serverUri('preface/create');

        $params = [
            'event'               => $this->params['present-event'],
            'name-representation' => $this->params['present-name'],
            'db-name'             => $this->params['present-dbname'],
            'table-name'          => $this->params['present-table'],
            'url'                 => $this->params['present-url'],
            'method'              => $this->params['present-method'],
            'count-request'       => $this->params['present-requests']
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