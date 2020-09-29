<?php

namespace System\Service;

use System\Service\Service\ServiceHandler;
use System\Service\Service\ServiceInterface;
use System\Support\Session\Session;

/**
 * Class ServiceSession
 * @package System\Service
 */
class ServiceSession extends ServiceHandler implements ServiceInterface
{

    /**
     * @var string
     */
    public $nameService = 'session';

    /**
     * @return $this|mixed
     */
    public function init()
    {
        $class = new Session();
        
        $this->cm->set($this->nameService, $class);
        
        return $this;
    }
    
}