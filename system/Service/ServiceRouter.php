<?php

namespace System\Service;

use System\Service\Service\ServiceHandler;
use System\Service\Service\ServiceInterface;
use System\Router\Router;

/**
 * Class ServiceRouter
 * @package System\Service
 */
class ServiceRouter extends ServiceHandler implements ServiceInterface
{

    /**
     * @var string
     */
    public $nameService = 'router';

    /**
     * @return $this|mixed
     */
    public function init()
    {
        $class = new Router();
        
        $this->cm->set($this->nameService, $class);
        
        return $this;
    }
    
}