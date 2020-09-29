<?php

namespace System\Service;

use System\Service\Service\ServiceHandler;
use System\Service\Service\ServiceInterface;
use System\Inc\File;

/**
 * Class ServiceInc
 * @package System\Service
 */
class ServiceInc extends ServiceHandler implements ServiceInterface
{

    /**
     * @var string
     */
    public $nameService = 'file';

    /**
     * @return $this|mixed
     */
    public function init()
    {
        $class = new File();
        
        $this->cm->set($this->nameService, $class);
        
        return $this;
    }
    
}