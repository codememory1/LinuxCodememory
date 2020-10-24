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
     * authModel
     *
     * @var mixed
     */
    private $authModel;

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
        $this->authModel = $this->model->load('Auth');
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

        $repr = $this->model->load('Representation');

        if($this->common->invalidToken() === true)
        {
            $authModel = $this->model->load('Auth');

            $authModel->auth($repr);
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

        if($this->common->invalidToken() === true) {
            $this->authModel->checkConfirm($this->request->get('login'));
        }

    }
    
    /**
     * connection
     *
     * @param  mixed $server
     * @param  mixed $login
     * @param  mixed $password
     * @return void
     */
    public function connection($server, $login, $password)
    {

        $password = $password === 'null' ? '' : $password;

        $servers = [
            'server' => explode(':', $server)[0],
            'port'   => explode(':', $server)[1]
        ];

        $this->authModel->curlAuth($servers['server'], $servers['port'], $login, $password);

    }
    
}