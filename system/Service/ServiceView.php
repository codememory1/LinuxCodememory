<?php

namespace System\Service;

use System\Service\Service\ServiceHandler;
use System\Service\Service\ServiceInterface;
use System\Codememory\AbstractComponent\View;

/**
 * Class ServiceRequest
 * @package System\Service
 */
class ServiceView extends ServiceHandler implements ServiceInterface
{

    /**
     * @var string
     */
    public $nameService = 'view';

    /**
     * @return $this|mixed
     */
    public function init()
    {
        $class = new View();
        
        $this->cm->set($this->nameService, $class);
        
        return $this;
    }
    
}