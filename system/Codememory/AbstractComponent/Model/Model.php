<?php

namespace System\Codememory\AbstractComponent\Model;

use System\Codememory\RegisterService;

/**
 * Class Model
 * @package System\Codememory\AbstractComponent
 */
abstract class Model extends RegisterService
{

    /**
     * Model constructor.
     */
    public function __construct()
    {

        parent::__construct();
		
    }
	

}