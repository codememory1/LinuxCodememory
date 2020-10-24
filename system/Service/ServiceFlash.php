<?php

namespace System\Service;

use System\Service\Service\ServiceHandler;
use System\Service\Service\ServiceInterface;
use System\Support\Session\Flash;

/**
 * Class ServiceEnv
 * @package System\Service
 */
class ServiceFlash extends ServiceHandler implements ServiceInterface
{

    /**
     * @var string
     */
    public $nameService = 'flash';

    /**
     * @return $this|mixed
     */
    public function init()
    {
        $class = new Flash();
        
        $this->cm->set($this->nameService, $class);
        
        return $this;
    }
    
}