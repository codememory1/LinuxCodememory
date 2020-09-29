<?php

namespace System\Service;

use System\Service\Service\ServiceHandler;
use System\Service\Service\ServiceInterface;
use System\Database\Mongo\MongoQueryBuilder;

/**
 * Class ServiceModel
 * @package System\Service
 */
class ServiceMongo extends ServiceHandler implements ServiceInterface
{

    /**
     * @var string
     */
    public $nameService = 'mongo';

    /**
     * @return $this|mixed
     */
    public function init()
    {
        $class = new MongoQueryBuilder();
        
        $this->cm->set($this->nameService, $class);
        
        return $this;
    }
    
}