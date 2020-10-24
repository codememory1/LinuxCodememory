<?php

namespace System\Service;

use System\Service\Service\ServiceHandler;
use System\Service\Service\ServiceInterface;
use System\Inc\FopenFile;

/**
 * Class ServiceFopenFile
 * @package System\Service
 */
class ServiceFopenFile extends ServiceHandler implements ServiceInterface
{

    /**
     * @var string
     */
    public $nameService = 'fopen';

    /**
     * @return $this|mixed
     */
    public function init()
    {
        $class = new FopenFile();
        
        $this->cm->set($this->nameService, $class);
        
        return $this;
    }
    
}