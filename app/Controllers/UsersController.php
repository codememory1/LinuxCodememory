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
        $this->usersModel = $this->model->load('Users');
    }
    
    /**
     * list
     *
     * @return void
     */
    public function list()
    {

        $this->common->checkAccess('check-all-users');

        $this->view->big('list-users', ['users' => $this->usersModel->getInfoUsers()]);
        
    }

    /**
     * bannedAccount
     *
     * @return void
     */
    public function bannedAccount()
    {

        $req = $this->request->post('banned-account') == 'on' ? true : false;

        $this->usersModel->bannedAccount($this->request->post('user-hash'), $req);

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
            $this->usersModel->createUser(); 
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

        $this->usersModel->deleteUser($this->request->get('login') ?? '?');

    }
    
    /**
     * editAccess
     *
     * @return void
     */
    public function editAccess()
    {

        $this->common->checkAccess('edit-user-access');

        if($this->usersModel->existsUser('opened', $this->request->get('login')) === false) {
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

        if($model->existsUser('opened', $this->request->get('login')) === false) {
            Response::setResponseCode(404)->getContentResponseCode();
        }

        if($this->common->invalidToken() === true) {
            $this->usersModel->editAccess($this->request->get('login'));
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
        $username = $this->request->get('login');

        if($this->usersModel->existsUser('opened', $username) === false) {
            Response::setResponseCode(404)->getContentResponseCode();
        }

        $this->view->big('edit-user-info', ['userdata' => $this->usersModel->getUserData($this->usersModel->getFullServer('server-dir'), $username)]);

    }
    
    /**
     * editUserHandler
     *
     * @return void
     */
    public function editUserHandler()
    {

        $this->common->checkAccess('edit-user-info');
        $username = $this->request->get('login');
        
        if($this->usersModel->existsUser('opened', $username) === false) {
            Response::setResponseCode(404)->getContentResponseCode();
        }

        if($this->common->invalidToken() === true) {
            // if($this->session->get('confirm-auth') !== null && ($this->session->get('confirm-auth') === $this->request->get('token-confirm-auth'))) {
            //     $model->editInfoUser($username);
            // }
            // else {
            //     \Redirector::his(route('FastDB.configm-auth'))->redirect();
            // }
            $this->usersModel->editInfoUser($username);
        }

    }
    
}