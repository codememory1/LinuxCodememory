<?php

namespace App\Controllers;

use System\Codememory\AbstractComponent\Controller;
use Redirector;

/**
 * Class
 * @package App\Consollers\AuthController
 */
class AuthController extends Controller
{
    
    /**
     * common
     *
     * @var mixed
     */
    private $common;

    /**
     * WebController constructor.
     *
     * @param $container
     */
    public function __construct()
    {
        parent::__construct();

        $this->common = $this->model->load('Common');
    }
    
    /**
     * auth
     *
     * @return void
     */
    public function auth()
    {

        $this->view->big('login');
		
    }
    
    /**
     * authHandler
     *
     * @return void
     */
    public function authHandler()
    {

        if($this->common->invalidToken() === true)
        {
            $authModel = $this->model->load('Auth');

            $authModel->auth();
        }

    }
    
    /**
     * logout
     *
     * @return void
     */
    public function logout()
    {

        $this->session->remove('authorize');
        $this->session->remove('confirm-auth');

        Redirector::back()->redirect();

    }
        
    /**
     * confirm
     *
     * @return void
     */
    public function confirm()
    {

        $this->view->big('confirm-auth');

    }

    /**
     * confirm
     *
     * @return void
     */
    public function confirmHandler()
    {

        $authModel = $this->model->load('Auth');

        if($this->common->invalidToken() === true) {
            $authModel->checkConfirm();
        }

    }
    
}