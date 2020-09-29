<?php

namespace System\Service;

use System\Service\Service\ServiceHandler;
use System\Service\Service\ServiceInterface;
use System\Inc\FileIni;

/**
 * Class ServiceIni
 * @package System\Service
 */
class ServiceIni extends ServiceHandler implements ServiceInterface
{

    /**
     * @var string
     */
    public $nameService = 'ini';

    /**
     * @return $this|mixed
     */
    public function init()
    {
        $class = new FileIni();
        
        $this->cm->set($this->nameService, $class);
        
        return $this;
    }
    
}