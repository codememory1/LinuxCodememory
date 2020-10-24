<?php

namespace System\Codememory\AbstractComponent;

use System\Codememory\AbstractComponent\Interfaces\ControllerInterface;
use System\Codememory\AbstractComponent\View;
use System\Codememory\RegisterService;
use System\Codememory\CodememoryContainer;

/**
 * Class Controller
 * @package System\Codememory\AbstractComponent
 */
abstract class Controller extends RegisterService implements ControllerInterface
{

    /**
     * Controller constructor.
     */
    public function __construct()
    {
		
        parent::__construct();
        
    }
    
}