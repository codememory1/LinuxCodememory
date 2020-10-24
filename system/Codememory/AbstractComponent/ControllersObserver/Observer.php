<?php

namespace System\Codememory\AbstractComponent\ControllersObserver;

use System\Codememory\AbstractComponent\Interfaces\ControllerInterface;

/**
 * Observer
 */
class Observer
{
    
    /**
     * controllers
     *
     * @var array
     */
    public $controllers = [];
    
    /**
     * setObserver
     *
     * @param  mixed $controller
     * @return void
     */
    public function setObserve(ControllerInterface ...$controller)
    {

        $this->controllers[] = $controller;

    }
    
    /**
     * getObController
     *
     * @return void
     */
    public function getObController()
    {

        return $this->controllers;

    }
    
    /**
     * register
     *
     * @param  mixed $observe
     * @return void
     */
    public function register($observe)
    {

        $observe->observe();

        return true;

    }

}