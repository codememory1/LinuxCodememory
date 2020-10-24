<?php

namespace System\Service;

use System\Service\Service\ServiceHandler;
use System\Service\Service\ServiceInterface;
use System\Codememory\AbstractComponent\Repository\Handle as HandleRepository;

/**
 * Class ServiceRepository
 * @package System\Service
 */
class ServiceRepository extends ServiceHandler implements ServiceInterface
{

    /**
     * @var string
     */
    public $nameService = 'repository';

    /**
     * @return $this|mixed
     */
    public function init()
    {
        $class = new HandleRepository();

        $this->cm->set($this->nameService, $class);

        return $this;
    }

}