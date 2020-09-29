<?php

namespace App\Models;

use System\Codememory\RegisterService;
use App\Models\Repositories\ConfigurationRepository;
use Store;
use Flash;
use Validator;
use Date;
use Response;

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
            'invalid_path_save_local'   => 'Укажите Диск к сохранению удаленных данных'
        ];

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

        return Response::arrayToJson([
            'status'   => $status,
            'message' => $this->getError($key)
        ]);

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
                }
            }
            $data['deleted-data']['asa'] = $as;

            return $data;
        });

        echo $this->getJsonError('success', 'successfull_save_settings');

    }

    public function turnSaveDeletedData(bool $status)
    {

        $this->editKeyUserInfo(function($data) use ($status) {
            $data['deleted-data']['save'] = $status;

            return $data;
        });

        echo $this->getJsonError('success', 'successfull_save_settings');

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