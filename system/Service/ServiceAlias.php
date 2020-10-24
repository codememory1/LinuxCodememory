<?php

namespace System\Service;

use System\Service\Service\ServiceHandler;
use System\Service\Service\ServiceInterface;
use System\Classes\AliasesContainer;

/**
 * Class ServiceAlias
 * @package System\Service
 */
class ServiceAlias extends ServiceHandler implements ServiceInterface
{

    /**
     * @var string
     */
    public $nameService = 'alias';

    /**
     * @return $this|mixed
     */
    public function init()
    {
        $class = new AliasesContainer();
        
        $this->cm->set($this->nameService, $class);
        
        return $this;
    }
    
}