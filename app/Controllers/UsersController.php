<?php

namespace App\Controllers;

use System\Codememory\AbstractComponent\Controller;
use Response;

/**
 * Class
 * @package App\Consollers\UsersController
 */
class UsersController extends Controller
{
    
    /**
     * common
     *
     * @var mixed
     */
    private $common;

    /**
     * UsersController constructor.
     *
     * @param $container
     */
    public function __construct()
    {
        parent::__construct();

        $this->common = $this->model->load('Common');
    }
    
    /**
     * list
     *
     * @return void
     */
    public function list()
    {

        $this->common->checkAccess('check-all-users');
        $model = $this->model->load('Users');

        $this->view->big('list-users', ['users' => $model->getInfoUsers()]);
        
    }

    /**
     * bannedAccount
     *
     * @return void
     */
    public function bannedAccount()
    {

        $req = $this->request->post('banned-account') == 'on' ? true : false;
        $model = $this->model->load('Users');

        $model->bannedAccount($this->request->post('user-hash'), $req);

    }
    
    /**
     * create
     *
     * @return void
     */
    public function create()
    {

        $this->common->checkAccess('create-user');
        $this->view->big('create-user');

    }
        
    /**
     * createHandler
     *
     * @return void
     */
    public function createHandler()
    {

        $this->common->checkAccess('create-user');

        if($this->common->invalidToken() === true && $this->common->memoryCheck() === true) {  
            $model = $this->model->load('Users');
            $model->createUser(); 
        }

    }
    
    /**
     * deleteUser
     *
     * @param  mixed $username
     * @return void
     */
    public function deleteUser($username)
    {

        $this->common->checkAccess('delete-user');
        $model = $this->model->load('Users');

        $model->deleteUser($this->request->get('login') ?? '?');

    }
    
    /**
     * editAccess
     *
     * @return void
     */
    public function editAccess()
    {

        $this->common->checkAccess('edit-user-access');
        $model = $this->model->load('Users');

        if($model->existsUser('opened', $this->request->get('login')) === false) {
            Response::setResponseCode(404)->getContentResponseCode();
        }
        $this->view->big('edit-user-access', ['common' => $this->common]);

    }
    
    /**
     * editAccessHandler
     *
     * @return void
     */
    public function editAccessHandler()
    {

        $this->common->checkAccess('edit-user-access');
        $model = $this->model->load('Users');

        if($model->existsUser('opened', $this->request->get('login')) === false) {
            Response::setResponseCode(404)->getContentResponseCode();
        }

        if($this->common->invalidToken() === true) {
            $model->editAccess($this->request->get('login'));
        }

    }
    
    /**
     * editUser
     *
     * @return void
     */
    public function editUser()
    {

        $this->common->checkAccess('edit-user-info');
        $model = $this->model->load('Users');
        $username = $this->request->get('login');

        if($model->existsUser('opened', $username) === false) {
            Response::setResponseCode(404)->getContentResponseCode();
        }

        $this->view->big('edit-user-info', ['userdata' => $model->getUserData($model->getFullServer('server-dir'), $username)]);

    }
    
    /**
     * editUserHandler
     *
     * @return void
     */
    public function editUserHandler()
    {

        $this->common->checkAccess('edit-user-info');

        $model = $this->model->load('Users');
        $username = $this->request->get('login');
        
        if($model->existsUser('opened', $username) === false) {
            Response::setResponseCode(404)->getContentResponseCode();
        }

        if($this->common->invalidToken() === true) {
            if($this->session->get('confirm-auth') !== true) {
                \Redirector::his(route('FastDB.configm-auth'))->redirect();
            }
            else {
                $model->editInfoUser($username);
            }
        }

    }
    
}