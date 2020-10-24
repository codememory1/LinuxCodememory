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
class StorageModel extends RegisterService
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

        return Response::arrayToJson([
            'status'   => $status,
            'message' => $this->getError($key)
        ]);

    }
    
    /**
     * getLocalDeletedData
     *
     * @param  mixed $usersModel
     * @return void
     */
    private function getLocalDeletedData($usersModel)
    {

        $resultScan = [];

        $path = $usersModel->getInfoUsers()[$this->getUsername()]['deleted-data']['path_local_save'].'FastDB/';

        $pathServer = $path.$this->getFullServer('server-dir');
        $pathUser = $path.$this->getFullServer('server-dir').'/'.$this->getUsername();

        if(is_dir($pathServer) && is_dir($pathUser)) {
            $scanUser = scandir($pathUser);
            $scanUser = array_diff($scanUser, ['.', '..']);

            if(count($scanUser) > 0) {
                foreach ($scanUser as $key => $valueDbname) 
                {
                    $regexName = '/^%s\=([a-zA-Z0-9\-\_\.]+)$/';

                    if(preg_match(sprintf($regexName, 'dbname'), $valueDbname)) {
                        $pathDb = $pathUser.'/'.$valueDbname.'/';
                        $scanDb = scandir($pathDb);
                        $scanDb = array_diff($scanDb, ['.', '..']);

                        if(count($scanDb) > 0) {
                            foreach ($scanDb as $key => $valueTablename) 
                            {
                                if(preg_match(sprintf($regexName, 'tablename'), $valueTablename)) {
                                    $pathTable = $pathDb.$valueTablename.'/';
                                    $pathData = $pathTable.'data.fd';

                                    if(file_exists($pathData) === true) {
                                        $checkData = file_get_contents($pathData);
                                        $checkData = Response::jsonToArray($checkData);

                                        $checkDataJson = json_encode($checkData, JSON_UNESCAPED_LINE_TERMINATORS);

                                        if(preg_match('/^\[(\{(\".*\"\:([0-9]+|null|false|true|\".*\"(\,)?)*)\}(\,)?)*\]$/', $checkDataJson)) {
                                            $resultScan[] = [
                                                'dbname' => explode('=', $valueDbname)[1],
                                                'table'  => explode('=', $valueTablename)[1],
                                                'data'   => $checkData
                                            ];
                                        } else {
                                            $resultScan[] = [
                                                'dbname' => explode('=', $valueDbname)[1],
                                                'table'  => explode('=', $valueTablename)[1],
                                                'data'   => []
                                            ];
                                        }
                                    }
                                }
                            }
                        } 
                    }
                }
            }
        }

        return $resultScan;

    }
        
    /**
     * getServerDeletedData
     *
     * @param  mixed $usersModel
     * @return void
     */
    private function getServerDeletedData($usersModel)
    {

        $deletedData = [];

        $path = $this->getPathServer($this->getFullServer('server-dir'), '/Databases/'.$this->getUsername().'/');
        $scanDb = Store::scan($path);

        if(count($scanDb) > 0) {
            foreach($scanDb as $dbname)
            {
                $pathDb = $path.$dbname.'/Tables/';
                $scanTable = Store::scan($pathDb);

                if(count($scanTable) > 0) {
                    foreach($scanTable as $tablename)
                    {
                        $pathTableStorage = $scanTable.$tablename.'/Store/deleted-data.fd';
                        $data = Response::jsonToArray(Store::getApi($pathTableStorage));

                        $resultScan[] = [
                            'dbname' => explode('=', $dbname)[1],
                            'table'  => explode('=', $tablename)[1],
                            'data'   => $data
                        ];

                    }
                }
            }
        }

        return $deletedData;

    }

    /**
     * getAll
     *
     * @param  mixed $usersModel
     * @return void
     */
    public function getAll($usersModel)
    {

        $resultScan = [];

        switch($usersModel->getInfoUsers()[$this->getUsername()]['deleted-data']['asa']) {
            case 'local':
                $resultScan = $this->getLocalDeletedData($usersModel);
                break;
            case 'server':
                $resultScan = $this->getServerDeletedData($usersModel);
                break;
            default: 
                $resultScan = $this->getServerDeletedData($usersModel);
        }

        return $resultScan;

    }

    private function saveLocal($usersModel, $dbname, $table, $data)
    {

        $path = $usersModel->getInfoUsers()[$this->getUsername()]['deleted-data']['path_local_save'];
        $pathTable = sprintf('FastDB/%s/%s/dbname=%s/tablename=%s', $this->getFullServer('server-dir'), $this->getUsername(), $dbname, $table);
        $fileData = $path.$pathTable.'/data.fd';

        $paths = [
            'FastDB',
            sprintf('FastDB/%s', $this->getFullServer('server-dir')),
            sprintf('FastDB/%s/%s/', $this->getFullServer('server-dir'), $this->getUsername()),
            sprintf('FastDB/%s/%s/%s', $this->getFullServer('server-dir'), $this->getUsername(), 'dbname='.$dbname),
            $pathTable
        ];

        foreach($paths as $dir)
        {
            Store::createDir($dir, $path);
        }
        
        if(file_exists($fileData) === false) {
            file_put_contents($fileData, Response::arrayToJson([$data]));
        } else {
            $dataCheck = file_get_contents($fileData);
            $dataCheck = Response::jsonToArray($dataCheck);
            $dataCheck[] = $data;
            file_put_contents($fileData, Response::arrayToJson($dataCheck));
        }

    }

    public function save($usersModel, $dbname, $table, $data)
    {

        $deletedData = $usersModel->getInfoUsers()[$this->getUsername()]['deleted-data'];
        
        if($deletedData['save'] === true) {
            if($deletedData['asa'] == 'local') {
                $this->saveLocal($usersModel, $dbname, $table, $data);
            }
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