<?php

namespace System\Service;

use System\Service\Service\ServiceHandler;
use System\Service\Service\ServiceInterface;
use System\Support\Mail;

/**
 * Class ServiceMail
 * @package System\Service
 */
class ServiceMail extends ServiceHandler implements ServiceInterface
{

    /**
     * @var string
     */
    public $nameService = 'mail';

    /**
     * @return $this|mixed
     */
    public function init()
    {
        $class = new Mail();
        
        $this->cm->set($this->nameService, $class);
        
        return $this;
    }
    
}