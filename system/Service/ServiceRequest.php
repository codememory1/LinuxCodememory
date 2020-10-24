<?php

namespace System\Service;

use System\Service\Service\ServiceHandler;
use System\Service\Service\ServiceInterface;
use System\Http\NewRequest;

/**
 * Class ServiceRequest
 * @package System\Service
 */
class ServiceRequest extends ServiceHandler implements ServiceInterface
{

    /**
     * @var string
     */
    public $nameService = 'request';

    /**
     * @return $this|mixed
     */
    public function init()
    {
        $class = new NewRequest();
        
        $this->cm->set($this->nameService, $class);
        
        return $this;
    }
    
}