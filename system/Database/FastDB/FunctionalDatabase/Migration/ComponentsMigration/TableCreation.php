<?php

namespace System\Database\FastDB\FunctionalDatabase\Migration\ComponentsMigration;

class TableCreation
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

        $handlerUri = $this->server->serverUri('table/create/handle', '&db='.$this->server->dbname);

        $fieldsArray = [
            'name-table'  => $this->params['table-name'],
		];
		
		foreach($this->params['data-fields'] as $fieldName => $dataField)
		{
			
			$fieldsArray['fields'][] = $fieldName;
			$fieldsArray['types'][] = $dataField['type'][0] ?? 'int';
			$fieldsArray['length'][] = $dataField['length'][0] ?? '';
			$fieldsArray['default'][] = $dataField['default'][0] ?? 'null';
			$fieldsArray['default-his'][] = $dataField['hisDefault'][0] ?? '';
			$fieldsArray['charset'][] = strtoupper($dataField['charset'][0] ?? 'utf-8');
			
        }

        $request = curl_init($handlerUri);
        curl_setopt($request, CURLOPT_DEFAULT_PROTOCOL, $this->server->protocol());
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_POST, true);
		curl_setopt($request, CURLOPT_POSTFIELDS, urldecode(http_build_query($fieldsArray)));
        
        $result = curl_exec($request);
        curl_close($request);

    }
    
}