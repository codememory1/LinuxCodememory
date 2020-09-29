<?php

namespace System\Service;

use System\Service\Service\ServiceHandler;
use System\Service\Service\ServiceInterface;
use System\Support\Common;

/**
 * Class ServiceCommon
 * @package System\Service
 */
class ServiceCommon extends ServiceHandler implements ServiceInterface
{

    /**
     * @var string
     */
    public $nameService = 'common';

    /**
     * @return $this|mixed
     */
    public function init()
    {
        $class = new Common();
        
        $this->cm->set($this->nameService, $class);
        
        return $this;
    }
    
}