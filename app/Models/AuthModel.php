<?php

namespace App\Models;

use System\Codememory\RegisterService;
use System\Authentication\Authorization;
use App\Models\Repositories\ConfigurationRepository;
use Store;
use Flash;
use Redirector;
use Session;
use Response;

/**
 * AuthModel
 * @package System\Codememory
 */
class AuthModel extends RegisterService
{
        
    /**
     * auth
     *
     * @var mixed
     */
    private $auth;
    
    /**
     * conf
     *
     * @var mixed
     */
    private $conf;
    
    /**
     * common
     *
     * @var mixed
     */
    private $common;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        
        parent::__construct();

        $this->auth = new Authorization();
        $this->conf = new ConfigurationRepository();
        $this->common = $this->model->load('Common');

    }
    
    /**
     * getErrors
     *
     * @param  mixed $key
     * @return void
     */
    private function getError($key)
    {

        $errors = [
            'server_not_found' => 'Данного сервера не существует.',
            'invalid_server'   => 'Некорректный сервер.',
            'min_username'     => 'Логин должен состовлять минимум 5 символов.',
            'max_username'     => 'Логин должен состовлять максимум 16 символов.',
            'invalid_username' => 'Некорректный логин.',
            'max_password'     => 'Пароль должен состовлять максимум 68 символов.',
            'not_autification' => 'Данного пользователя не существует.',
            'successfull_auth' => 'Вы ушспешно аутифицировались',
            'invalid_password_confirm' => 'Пароль не подтвержден. Выполнен выход из аккаунта.'
        ];

        return $errors[$key];

    }
    
    /**
     * replaceServer
     *
     * @return void
     */
    private function replaceServer()
    {

        return Store::replace([':' => '-'], $this->request->post('server'));

    }
    
    /**
     * existsServer
     *
     * @param  mixed $common
     * @return void
     */
    private function existsServer($common)
    {

        if(Store::isDir($common->getPathServer($this->replaceServer())) === false)
        {
            Flash::name('flash-error')->add('error', $this->getError('server_not_found'));

            return false;
        }

        return true;

    }
    
    /**
     * auth
     *
     * @param  mixed $common
     * @return void
     */
    public function auth()
    {

        $users = Response::jsonToArray(Store::getApi($this->conf->getPath('Users/list-all-users.fd')));
        
        $this->auth->configuration('array', $this->request->post(), null, $users)
            ->searchUser(['server', 'login', 'password'], [$this->request->post('server'), $this->request->post('login'), base64_encode($this->request->post('password'))])
            ->setValidation('server', ['regular:'.$this->conf->algFullServer], function($validate) {
                $validate->setMessageValidationArray([ $this->getError('invalid_server')]);
            }, true)
            ->setValidation('login', ['min:5', 'max:16', 'regular:/^[a-z0-9\_\-]+$/i'], function($validate) {
                $validate->setMessageValidationArray([ $this->getError('min_username'), $this->getError('max_username'), $this->getError('invalid_username')]);
            }, true)
            ->setValidation('password', ['max:68'], function($validate) {
                $validate->setMessageValidationArray([$this->getError('max_password')]);
            }, true)
            ->supplement(function() {
                return $this->existsServer($this->conf);
            })
            ->authorize(function($data) {
                Flash::name('flash-error')->add('success', $this->getError('successfull_auth'));

                Session::create('authorize', $data);

            })
            ->proccessErrors(function($errors) {
                if(count($errors) > 0)
                {
                    $errors['user_dont_exists'] =  $this->getError('not_autification');

                    Flash::name('flash-error')->add('error', array_shift($errors));
                }
            });

            Redirector::back()->redirect();

    }
    
    /**
     * checkConfirm
     *
     * @return void
     */
    public function checkConfirm()
    {

        $server = $this->conf->getFullServer('server-watch');
        $username = $this->conf->getUsername();
        $usersModel = $this->model->load('Users');
        $userid = $usersModel->searchIdUser($server, $username);

        $users = Response::jsonToArray(Store::getApi($this->conf->getPath('Users/list-all-users.fd')));

        if($users[$userid]['password'] === base64_encode($this->request->post('confirm-password'))) {
            $this->session->life(3600)->create('confirm-auth', true);

            Redirector::his($this->request->get('redirect') ?? '/fastdb/all-db')->redirect();
        } else  {
            Flash::name('flash-error')->add('error', $this->getError('invalid_password_confirm'));
            
            $this->session->remove('authorize');
            $this->session->remove('confirm-auth');
            
            Redirector::back()->redirect();
        }

    }

        

}