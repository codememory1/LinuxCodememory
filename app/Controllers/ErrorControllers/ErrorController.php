<?php

namespace App\Controllers\ErrorControllers;

use System\Codememory\AbstractComponent\Controller;

/**
 * ErrorController
 */
class ErrorController extends Controller
{
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        
        parent::__construct();

    }
    
    /**
     * NotFound
     *
     * @return void
     */
    public function NotFound() 
    {

        $this->view->big('404');

        exit();

    }
    
    /**
     * Forbidden
     *
     * @return void
     */
    public function Forbidden()
    {

        $this->view->big('403');

        exit();

    }

}