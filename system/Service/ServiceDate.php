<?php

namespace System\Service;

use System\Service\Service\ServiceHandler;
use System\Service\Service\ServiceInterface;
use System\Support\Date;

/**
 * Class ServiceDate
 * @package System\Service
 */
class ServiceDate extends ServiceHandler implements ServiceInterface
{

    /**
     * @var string
     */
    public $nameService = 'date';

    /**
     * @return $this|mixed
     */
    public function init()
    {
        $class = new Date();
        
        $this->cm->set($this->nameService, $class);
        
        return $this;
    }
    
}