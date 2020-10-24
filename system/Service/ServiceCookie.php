<?php

namespace System\Service;

use System\Service\Service\ServiceHandler;
use System\Service\Service\ServiceInterface;
use System\Support\Cookie;

/**
 * Class ServiceCookie
 * @package System\Service
 */
class ServiceCookie extends ServiceHandler implements ServiceInterface
{

    /**
     * @var string
     */
    public $nameService = 'cookie';

    /**
     * @return $this|mixed
     */
    public function init()
    {
        $class = new Cookie();
        
        $this->cm->set($this->nameService, $class);
        
        return $this;
    }
    
}