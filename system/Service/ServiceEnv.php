<?php

namespace System\Service;

use System\Service\Service\ServiceHandler;
use System\Service\Service\ServiceInterface;
use System\ENV\AppEnv;

/**
 * Class ServiceEnv
 * @package System\Service
 */
class ServiceEnv extends ServiceHandler implements ServiceInterface
{

    /**
     * @var string
     */
    public $nameService = 'env';

    /**
     * @return $this|mixed
     */
    public function init()
    {
        $class = new AppEnv();
        
        $this->cm->set($this->nameService, $class);
        
        return $this;
    }
    
}