<?php

namespace System\Service\Service;

use System\Codememory\CodememoryContainer;

/**
 * Class ServiceHandler
 * @package System\Service\Service
 */
class ServiceHandler 
{

    /**
     * @var Container
     */
    public $cm;

    /**
     * ServiceHandler constructor.
     */
    public function __construct()
    {
        
        $this->cm = new CodememoryContainer();
        
    }
    
}