<?php

namespace System\Service;

use System\Service\Service\ServiceHandler;
use System\Service\Service\ServiceInterface;
use System\Support\Random;

/**
 * Class ServiceRandom
 * @package System\Service
 */
class ServiceRandom extends ServiceHandler implements ServiceInterface
{

    /**
     * @var string
     */
    public $nameService = 'random';

    /**
     * @return $this|mixed
     */
    public function init()
    {
        $class = new Random();
        
        $this->cm->set($this->nameService, $class);
        
        return $this;
    }
    
}