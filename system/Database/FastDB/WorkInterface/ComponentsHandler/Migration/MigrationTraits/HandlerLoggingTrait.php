<?php

namespace System\Database\FastDB\WorkInterface\ComponentsHandler\Migration\MigrationTraits;

use System\Database\FastDB\WorkInterface\ComponentsHandler\Migration\MigrationInterfaces\ErrorRequestInterface;

trait HandlerLoggingTrait
{

    /**
     * setLogging
     *
     * @param  mixed $title
     * @param  mixed $status
     * @param  mixed $response
     * @return void
     */
    public function setLogging(string $title, $response, $interface)
    {

        $interface->execSettings->setLoggingTitle($title)
        ->setLoggingContent($response->getBody());

        $responseText = json_decode($response->getBody(), true);

        switch($responseText['status']) {
            case 'success': 
                $interface->execSettings->setSuccessLog();
                break;
            case 'error':
                $interface->execSettings->setErrorLog();
                break;
        }

    }
    
    /**
     * getResponseCode
     *
     * @param  mixed $code
     * @return array
     */
    public function getResponseCode(string $code):array
    {

        return [
            'message' => constant('self::ERR_'.$code)
        ];

    }

}