<?php

namespace System\Service;

use System\Service\Service\ServiceHandler;
use System\Service\Service\ServiceInterface;
use System\Codememory\AbstractComponent\Model\Handle as HandleModel;

/**
 * Class ServiceModel
 * @package System\Service
 */
class ServiceModel extends ServiceHandler implements ServiceInterface
{

    /**
     * @var string
     */
    public $nameService = 'model';

    /**
     * @return $this|mixed
     */
    public function init()
    {
        $class = new HandleModel();
        
        $this->cm->set($this->nameService, $class);
        
        return $this;
    }
    
}