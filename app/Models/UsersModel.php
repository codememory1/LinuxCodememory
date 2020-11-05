<?php

namespace App\Models;

use System\Codememory\RegisterService;
use App\Models\Repositories\ConfigurationRepository;
use Store;
use Flash;
use Validator;
use Date;
use Response;
use Redirector;
use Random;

/**
 * DatabaseModel
 * @package System\Codememory
 */
class UsersModel extends RegisterService
{

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
     * create
     *
     * @var mixed
     */
    private $create;
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        
        parent::__construct();
        $this->conf = new ConfigurationRepository();
        $this->common = $this->model->load('Common');
        $this->create = $this->model->load('CreateFiles');

    }
        
    /**
     * existsUser
     *
     * @param  mixed $server
     * @param  mixed $username
     * @return void
     */
    public function existsUser(string $server = 'opened', string $username)
    {
        $server = $server === 'opened' ? $this->getFullServer('server-dir') : $server;

        return Store::isDir($this->getPathServer($server, 'Users/'.$username));

    }
    
    /**
     * searchIdUser
     *
     * @param  mixed $server
     * @param  mixed $username
     * @return void
     */
    public function searchIdUser(string $server, string $username)
    {

        $pathAllUsers = 'FastDB/Users/list-all-users.fd';
        $users = Response::jsonToArray(Store::getApi($pathAllUsers));
        $id = null;

        foreach($users as $k => $user)
        {
            if($user['server'] === $server && $user['login'] === $username)
            {
                $id = $k;
            }
        }

        return $id;

    }

    /**
     * getError
     *
     * @param  mixed $key
     * @return void
     */
    public function getError(string $key)
    {

        $errors = [
            'user_not_found'             => 'Пользователь не найден.',
            'user_successfull_freeze'    => 'Пользователь успешно заморожен.',
            'user_successfull_un_freeze' => 'Пользователь успешно разморожен.',
            'username_min_symbol'        => 'Логин пользователя не должен быть меньше 5 символов',
            'username_max_symbol'        => 'Логин пользователя не должен быть больше 30 символов',
            'username_regular'           => 'Некорректный логин пользователя',
            'invalid_info_checkbox'      => 'Некорректно задана информация',
            'user_exists'                => 'Пользователь с таким логином ужесуществует.',
            'error_select_mememory'      => 'Память должна выбрана в диапазоне от 50 МБ до 600 МБ',
            'successfull_create_user'    => 'Пользователь успешно создан',
            'user_successfull_deleted'   => 'Пользователь успешно удален.',
            'access_successfull_edit'    => 'Права пользователя успешно изминены.',
            'success_edit_info_user'     => 'Данные пользователя успешно изменены'
        ];

        if($this->request->get('json')) echo Response::arrayToJson(['response' => $errors[$key]]);

        return $errors[$key];

    }
    
    /**
     * getJsonError
     *
     * @param  mixed $status
     * @param  mixed $key
     * @return void
     */
    public function getJsonError(string $status, string $key)
    {

        return Response::arrayToJson(['status' => $status, 'message' => $this->getError($key)]);
        
    }

    /**
     * getInfoUsers
     *
     * @return void
     */
    public function getInfoUsers()
    {

        $path = $this->getPathServer($this->getFullServer('server-dir'), 'Users');
        $users = Store::scan($path);
        $dataUsers = [];

        foreach($users as $user)
        {
            $data = Response::jsonToArray(Store::getApi($path.'/'.$user.'/information-user.fd'));
            $dataUsers[$user] = $data;
        }

        return $dataUsers;

    }
    
    /**
     * getInfoUserCurrent
     *
     * @return void
     */
    public function getInfoUserCurrent()
    {

        return $this->getInfoUsers()[$this->getUsername()];

    }
    
    /**
     * bannedAccount
     *
     * @param  mixed $hash
     * @param  mixed $status
     * @return void
     */
    public function bannedAccount(string $hash, bool $status)
    {

        $userData = $this->getUserByHash($hash, $this->getFullServer('server-dir'));
        
        if($userData['data'] === []) {
            echo $this->getJsonError('error', 'user_not_found');
        }
        else {
            Store::editJsonFile($userData['path'].'.fd')->editJsonData(function($data) use ($status) {
                $data['freeze-account'] = $status;
                return $data;
            });
            if($status === true) {
                echo $this->getJsonError('warning', 'user_successfull_freeze');
            } else {
                echo $this->getJsonError('success', 'user_successfull_un_freeze');
            }
        }

    }
        
    /**
     * validatorInputUser
     *
     * @return void
     */
    private function validatorInputUser()
    {
        $info = $this->getInfoUsers()[$this->request->get('login')];

        $username = replaceArrayValue([$this->request->post('username')], [$info['username']], 'username');
        $saveAs = replaceArrayValue([$this->request->post('as-save-deleted-data')], [$info['deleted-data']['asa']], 'saveAs')['saveAs'];
        $freeze = replaceArrayValue([$this->request->post('as-save-deleted-data')], [$info['freeze-account']], 'freeze-account')['freeze-account'] === true ? 'on' : 'off';

        $validate = Validator::field('username', $username['username'])
            ->with('username', function($validator) {
                $validator->validation('min:5')
                    ->setMessage($this->getError('username_min_symbol'))
                ->validation('max:30')
                    ->setMessage($this->getError('username_max_symbol'))
                ->validation('regular:/^[a-z0-9\_]+$/i')
                    ->setMessage($this->getError('username_regular'));
            })
            ->field('save-deleted-data-as', $saveAs)
            ->with('save-deleted-data-as', function($validator) {
                $validator->validation('only:(server,local)')
                    ->setMessage($this->getError('invalid_info_checkbox'));
            })
            ->field('freeze-account', $freeze)
            ->with('freeze-account', function($validator) {
                $validator->validation('only:(on,off)')
                    ->setMessage($this->getError('invalid_info_checkbox'));
            })
            ->make();

        return $validate;

    }
    
    /**
     * validatorSelectMememoryUser
     *
     * @return void
     */
    private function validatorSelectMememoryUser()
    {

        if($this->request->post('max-memory') > 600 || $this->request->post('max-memory') < 50) {
            
            Flash::name('flash-error')->add('error', $this->getError('error_select_mememory'));
        } else {
            return true;
        }

    }

    /**
     * validateCreateUser
     *
     * @return void
     */
    private function validateCreateUser()
    {

        $validate = $this->validatorInputUser();

        if($validate->validated === true) {
            $this->checkUserRegisterExists();
        }
        else {
            Flash::name('flash-error')->add('error', $validate->getError());

            return false;
        }
    }
    
    /**
     * checkUserRegisterExists
     *
     * @return void
     */
    private function checkUserRegisterExists()
    {

        $exists = $this->existsUser($this->getFullServer('server-dir'), $this->request->post('username'));

        if($exists === true) {
            Flash::name('flash-error')->add('error', $this->getError('user_exists'));
        }
        else {
            $this->checkSelectMememory();
        }
    }
    
    /**
     * checkSelectMememory
     *
     * @return void
     */
    private function checkSelectMememory()
    {

        $memory = $this->validatorSelectMememoryUser();
        
        if($memory === true) {
            $this->createUserHandler();
        }

    }
    
    /**
     * createUserHandler
     *
     * @return void
     */
    private function createUserHandler()
    {

        $access = [];

        foreach($this->request->post('privilege') as $name => $status) 
        {
            $access[$name] = $status === 'on' ? true : false;
        }

        $userData = [
            'data' => [
                'server'   => $this->getFullServer('server'),
                'port'     => (int) $this->getFullServer('port'),
                'username' => $this->request->post('username'),
                'password' => base64_encode($this->request->post('password')),
                'hash'     => Random::randAny(36),
                'date-created'   => Date::format('Y-m-d H:i'),
                'freeze-account' => $this->request->post('freeze-account') === 'on' ? true : false,
                'memory' => [
                    'used'   => 0,
                    'of'     => (int) $this->request->post('max-memory'),
                    'unit'   => 'MB',
                    'units'  => [
                        'GB' => 1000000000,
                        'MB' => 1000000
                    ]
                ],
                'access-rights' => $access,
                'deleted-data'  => [
                    'save'            => $this->request->post('save-deleted-data') === 'on' ? true : false,
                    'asa'             => $this->request->post('as-save-deleted-data'),
                    'path_local_save' => null
                ]
            ],
            'logger' => [
                'connections' => []
            ]
        ];

        $this->create->createUser($this->getFullServer('server-dir'), $this->request->post('username'), $userData);
        Flash::name('flash-error')->add('success', $this->getError('successfull_create_user'));

    }
    
    /**
     * createUser
     *
     * @return void
     */
    public function createUser()
    {
        
        $this->validateCreateUser();

        Redirector::back()->redirect();

    }
    
    /**
     * deleteUser
     *
     * @param  mixed $username
     * @return void
     */
    public function deleteUser(string $username)
    {
        $statusAuthUser = false;

        if($this->searchIdUser($this->getFullServer('server-watch'), $username) === null) {
            Flash::name('flash-error')->add('error', $this->getError('user_not_found'));
        }
        else {
            if($this->getUserData($this->getFullServer('server-dir'), $username)['hash'] === $this->getUserData($this->getFullServer('server-dir'), $this->getUsername())['hash']) {
                $statusAuthUser = true;
            }

            $this->create->deleteUser($this->getFullServer('server-dir'), $this->searchIdUser($this->getFullServer('server-watch'), $username), $username);
            $statusAuthUser === true ? $this->session->remove('authorize') : false;

            Flash::name('flash-error')->add('success', $this->getError('user_successfull_deleted'));
        }

        Redirector::back()->redirect();

    }
    
    /**
     * editAccess
     *
     * @param  mixed $username
     * @return void
     */
    public function editAccess(string $username)
    {

        $path = $this->getPathServer($this->getFullServer('server-dir'), 'Users/'.$username.'/information-user.fd');

        Store::editJsonFile($path)->editJsonData(function($data) {
            $access = $this->request->post('privilege');

            foreach($access as $name => $status) 
            {
                $data['access-rights'][$name] = $status === 'on' ? true : false;
            }

            return $data;
        });

        Flash::name('flash-error')->add('success', $this->getError('access_successfull_edit'));
        Redirector::back()->redirect();

    }
        
    /**
     * handlerEditInfoUser
     *
     * @param  mixed $username
     * @param  mixed $newUsername
     * @return void
     */
    private function handlerEditInfoUser(string $username, string $newUsername)
    {

        $path = $this->getPathServer($this->getFullServer('server-dir'), 'Users/');
        $id = $this->searchIdUser($this->getFullServer('server-watch'), $username);
        $pathAll = 'FastDB/Users/list-all-users.fd';
        $pathOpenedUser = $path.$username;

        Store::editJsonFile($pathAll)->editJsonData(function($data) use ($id, $newUsername) {
            $data[$id]['login'] = $newUsername;
            $data[$id]['password'] = base64_encode($this->request->post('password'));

            return $data;
        });

        Store::editJsonFile($pathOpenedUser.'/information-user.fd')->editJsonData(function($data) {
            $commonData = replaceArrayValue([$this->request->post('username'), base64_encode($this->request->post('password')), $this->request->post('freeze-account') === 'on' ? true : false], [$data['username'], $data['password'], $data['freeze-account']], 'username', 'password', 'freeze-account');

            foreach($commonData as $k => $v)
            {
                $data[$k] = $v;
            }

            $store = replaceArrayValue(
                [$this->request->post('save-deleted-data') === 'on' ? true : false, $this->request->post('as-save-deleted-data')],
                [$data['deleted-data'], $data['asa']],
                'save', 'asa'
            );

            foreach($store as $k => $v)
            {
                $data['deleted-data'][$k] = $v;
            }

            $memory = replaceArrayValue(
                [$this->request->post('max-memory')],
                [$data['memory']['of']],
                'of'
            );

            foreach($memory as $k => $v)
            {
                $data['memory'][$k] = $v;
            }

            return $data;
        });

        Store::move($path.$username, $path.$newUsername);
        Store::move($this->getPathServer($this->getFullServer('server-dir'), 'Databases/').$username, $this->getPathServer($this->getFullServer('server-dir'), 'Databases/').$newUsername);
        Store::move($this->getPathServer($this->getFullServer('server-dir'), 'Representation/').$username, $this->getPathServer($this->getFullServer('server-dir'), 'Representation/').$newUsername);
        Flash::name('flash-error')->add('success', $this->getError('success_edit_info_user'));
        $this->session->remove('authorize');

        Redirector::his(route('FastDB.edit-user').'?login='.$newUsername)->redirect();

    }
    
    /**
     * getAutoInfoUser
     *
     * @param  mixed $username
     * @return array
     */
    private function getAutoInfoUser(string $username):array
    {

        $info = $this->getInfoUsers()[$username];

        $data = replaceArrayValue([
            $this->request->post('username'),
            $this->request->post('password'),
            $this->request->post('max-memory')
        ],
        [
            $info['username'],
            $info['password'],
            $info['memory']['of']
        ],'username', 'password', 'max-mememory');

        return $data;

    }

    /**
     * editInfoUser
     *
     * @param  mixed $username
     * @return void
     */
    public function editInfoUser(string $username)
    {

        $validator = $this->validatorInputUser();
        $server = $this->getFullServer('server-dir');
        $validate = true;

        if($validator->validated === true) {
            
            if($this->validatorSelectMememoryUser() === true) {
                $userdata = $this->getUserData($server, $username);
                
                if($userdata['username'] !== $this->getAutoInfoUser($username)['username']) {
                    $validate = $this->existsUser('opened', $this->getAutoInfoUser($username)['username']);
                    
                    $this->existsUser('opened', $this->getAutoInfoUser($username)['username']) === true ? Flash::name('flash-error')->add('error', $this->getError('user_exists')) : $this->handlerEditInfoUser($username, $this->getAutoInfoUser($username)['username']);
                } else {
                    
                    $this->handlerEditInfoUser($username, $this->getAutoInfoUser($username)['username']);
                }
            }
        }
        else {
            Flash::name('flash-error')->add('error', $validator->getError());
        }

        if($validate === true) {
            Redirector::route('FastDB.auth')->redirect();
        }
    }

    /**
     * __call
     *
     * @param  mixed $name
     * @param  mixed $arguments
     * @return void
     */
    public function __call($name, $arguments)
    {
        
        return call_user_func_array([$this->conf, $name], $arguments);

    }

}