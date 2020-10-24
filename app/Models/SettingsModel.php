<?php

namespace App\Models;

use System\Codememory\RegisterService;
use App\Models\Repositories\ConfigurationRepository;
use Store;
use Flash;
use Validator;
use Date;
use Response;
use Random;
use Redirector;

/**
 * DatabaseModel
 * @package System\Codememory
 */
class SettingsModel extends RegisterService
{
        
    /**
     * regexDbname
     *
     * @var string
     */
    private $regexTablename = '/^[a-z0-9\-\_\.]+$/i';

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
     * getError
     *
     * @param  mixed $key
     * @return void
     */
    public function getError(string $key)
    {

        $errors = [
            'successfull_save_settings' => 'Настройки успешно обновлены!',
            'invalid_path_save_local'   => 'Укажите Диск к сохранению удаленных данных',
            'invalid_local_path'        => 'Некорректный путь диска',
            'invalid_user_hash'         => 'Некорректный Hash',
            'successfull_update_token'  => 'Токен успешно обновлен'
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
    public function getJsonError(string $status, string $key, array $add = [])
    {

        $data = [
            'status'   => $status,
            'message'  => $this->getError($key)
        ];
        
        if($add !== []) $data += $add;

        return Response::arrayToJson($data);

    }

    /**
     * editKeyUserInfo
     *
     * @param  mixed $func
     * @return void
     */
    private function editKeyUserInfo($func)
    {

        $server = $this->getFullServer('server-dir');
        $username = $this->getUsername();
        $path = $this->getPathUser($server, $username);

        Store::editJsonFile($path.'information-user.fd')
        ->editJsonData($func);

    }

    /**
     * editAsSavingDeletedData
     *
     * @param  mixed $as
     * @return void
     */
    public function editAsSavingDeletedData(string $as)
    {

        $this->editKeyUserInfo(function($data) use ($as) {
            if($as === 'local') {
                if($data['deleted-data']['path_local_save'] === null) {
                    echo $this->getJsonError('error', 'invalid_path_save_local');
                    exit();
                } else {
                    $data['deleted-data']['asa'] = $as;
                }
            } 
            else {
                $data['deleted-data']['asa'] = $as;
            }

            return $data;
        });

        echo $this->getJsonError('success', 'successfull_save_settings');

    }
    
    /**
     * turnSaveDeletedData
     *
     * @param  mixed $status
     * @return void
     */
    public function turnSaveDeletedData(bool $status)
    {

        $this->editKeyUserInfo(function($data) use ($status) {
            $data['deleted-data']['save'] = $status;

            return $data;
        });

        echo $this->getJsonError('success', 'successfull_save_settings');

    }
    
    /**
     * validateLocalPath
     *
     * @return bool
     */
    private function validateLocalPath():bool
    {

        $regex = '/^[A-Z]{1}\:(.*)?/';

        if(!empty($this->request->post('path-save-local'))) {
            if(!preg_match($regex, $this->request->post('path-save-local'))) {
                Flash::name('flash-error')->add('error', $this->getError('invalid_local_path'));

                return false;
            }
        }

        return true;

    }
    
    /**
     * saveUserSettings
     *
     * @return void
     */
    public function saveUserSettings()
    {

        $usersModel = $this->model->load('Users');
        $pathCurrentUser = $this->getPathServer($this->getFullServer('server-dir'), 'Users/'.$this->getUsername());
        
        if($this->validateLocalPath() === true)
        {
            $userdata = $usersModel->getInfoUserCurrent();
            $resultData = replaceArrayValue([
                $this->request->post('save-deleted-data'),
                $this->request->post('as-save-deleted-data'),
                $this->request->post('path-save-local')
            ], $userdata['deleted-data'], 'save', 'asa', 'path_local_save');
            $password = replaceArrayValue([
                base64_encode($this->request->post('password'))
            ], [$userdata['password']], 'password');

            Store::editJsonFile($pathCurrentUser.'/information-user.fd')
            ->editJsonData(function($data) use($resultData, $password){
                foreach($resultData as $k => $v)
                {
                    if($k === 'save') $v = $v === 'on' ? true : false;
                    if($k === 'asa') $v = $v !== 'server' ? 'local' : 'server';
                    if($k === 'path_local_save') $v = (!empty($v)) ? Store::replace(['\\' => '/'], trim($v, '/').'/') : null;

                    $data['deleted-data'][$k] = $v;
                }

                $data['password'] = $password['password'];

                return $data;
            });
        }

        Redirector::back()->redirect();

    }
    
    /**
     * updateToken
     *
     * @return void
     */
    public function updateToken()
    {

        $pathCurrentUser = $this->getPathServer($this->getFullServer('server-dir'), 'Users/'.$this->getUsername());
        $token = Random::randAny(36);

        Store::editJsonFile($pathCurrentUser.'/information-user.fd')
            ->editJsonData(function($data) use($token){
                $data['hash'] = $token;

                return $data;
            });

        echo $this->getJsonError('success', 'successfull_update_token', ['token' => $token]);

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