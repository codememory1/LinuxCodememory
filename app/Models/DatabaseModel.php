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

/**
 * DatabaseModel
 * @package System\Codememory
 */
class DatabaseModel extends RegisterService
{
        
    /**
     * regexDbname
     *
     * @var string
     */
    private $regexDbname = '/^[a-z0-9\-\_\.]+$/i';

    /**
     * conf
     *
     * @var mixed
     */
    public $conf;
    
    /**
     * common
     *
     * @var mixed
     */
    public $common;
    
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
    public function getError($key) 
    {

        $errors = [
            'error_regex_dbname'   => 'Некорректно задано имя Базы Данных.',
            'min_symbol_dbname'    => 'Имя БД должно быть не меньше 5 символов.',
            'max_symbol_dbname'    => 'Имя БД должно быть не больше 20 символов.',
            'invalid_charset'      => 'Некорректно выбрана кодировка.',
            'db_exists'            => 'База данных %s уже существует.',
            'success_create_db'    => 'База Данных успешно спроектирована.',
            'foribidden_delete_db' => 'У вас нет прав для удаления данной БД.'
        ];

        return $errors[$key];

    }

    /**
     * list
     *
     * @return array
     */
    public function list():array
    {

        $path = $this->conf->getPathDb($this->conf->getFullServer()['server-dir'], $this->conf->getUsername());

        $map = array_map(function($database) {
            list($db, $name) = explode('=', $database);

            return $name;
        }, Store::scan($path));

        return $map;

    }
    
    /**
     * getInfo
     *
     * @param  mixed $dbname
     * @return void
     */
    public function getInfo(string $dbname)
    {

        $path = $this->conf->getPathDb($this->conf->getFullServer()['server-dir'], $this->conf->getUsername());

        return Response::jsonToArray(Store::getApi($path.'database='.$dbname.'/information-database.fd'));

    }
    
    /**
     * getSize
     *
     * @param  mixed $dbname
     * @return void
     */
    public function getSize(string $dbname)
    {

        $path = $this->conf->getPathDb($this->conf->getFullServer()['server-dir'], $this->conf->getUsername());

        return Store::completeSize($path.'database='.$dbname);

    }
    
    /**
     * listWithTables
     *
     * @return void
     */
    public function listWithTables()
    {

        $path = $this->conf->getPathDb($this->getFullServer()['server-dir'], $this->getUsername());
        $databases = Store::scan($path);

        $dbWithTables = [];

        foreach($databases as $k => $db)
        {
            $pathToDb = $path.$db.'/Tables';
            $tables = array_map(function($table) {
                list($table, $name) = explode('=', $table);
    
                return $name;
            }, Store::scan($pathToDb));

            $dbWithTables[$this->list()[$k]] = $tables;
        }
        
        return $dbWithTables;

    }
    
    /**
     * pathDb
     *
     * @param  mixed $server
     * @param  mixed $username
     * @return string
     */
    public function pathDb($server, $username):string
    {

        return $this->getPathServer($server, 'Databases/'.$username.'/');

    }
    
    /**
     * existsDb
     *
     * @param  mixed $server
     * @param  mixed $username
     * @param  mixed $dbname
     * @return void
     */
    public function existsDb($server, $username, $dbname)
    {

        return Store::isDir($this->pathDb($server, $username).'database='.$dbname);

    }
    
    /**
     * validateCreationDb
     *
     * @param  mixed $dbname
     * @return void
     */
    private function validateCreationDb($dbname)
    {

        $validate = Validator::field('dbname', $dbname)
            ->with('dbname', function($validator) {
                $validator->validation('regular:'.$this->regexDbname)
                    ->setMessage($this->getError('error_regex_dbname'))
                ->validation('min:5')
                    ->setMessage($this->getError('min_symbol_dbname'))
                ->validation('max:20')
                    ->setMessage($this->getError('max_symbol_dbname'));
            })
            ->field('charset', $this->request->post('charset'))
            ->with('charset', function($validator) {
                $validator->validation('only:('.implode(',', mb_list_encodings()).')')
                    ->setMessage($this->getError('invalid_charset'));
            })
            ->make();

        if($validate->validated === false)
        {
            Flash::name('flash-error')->add('error', $validate->getError());

            return false;
        }

        return true;

    }
    
    /**
     * existsCreationDb
     *
     * @return void
     */
    private function existsCreationDb($dbname)
    {
        
        $exists = $this->existsDb($this->getFullServer('server-dir'), $this->getUsername(), $dbname);

        if($exists === true) {
            Flash::name('flash-error')->add('error', sprintf($this->getError('db_exists'), $dbname));

            return false;
        }

        return true;

    }
    
    /**
     * createDatabase
     *
     * @return void
     */
    public function createDatabase()
    {

        $dbname = trim($this->request->post('db-name'));
        $validate = $this->validateCreationDb($dbname);
        $existsDB = $this->existsCreationDb($dbname);
        $data = [
            'information' => [
                'name'          => $dbname,
                'charset'       => $this->request->post('charset'),
                'creator'       => $this->getUsername(),
                'date-create'   => Date::format('Y-m-d H:i'),
                'remove-access' => true
            ],
            'statistics' => [
                'requests' => 0
            ]
        ];

        if($validate === true && $existsDB === true) {
            $this->create->createDatabase($this->getFullServer('server-dir'), $this->getUsername(), $dbname, $data);
            Flash::name('flash-error')->add('success', $this->getError('success_create_db'));
        }

        \Redirector::back()->redirect();

    }
        
    /**
     * deleteDatabase
     *
     * @param  mixed $dbname
     * @return void
     */
    public function deleteDatabase(string $dbname)
    {

        $path = $this->pathDb($this->getFullServer('server-dir'), $this->getUsername()).$this->getFileDb($dbname);
        $info = $this->getInfo($dbname)['information'];

        if(!$info['remove-access']) {
            Flash::name('flash-error')->add(['error'], $this->getError('foribidden_delete_db'));
            Redirector::back()->redirect();
            
            exit();
        }

        Store::completeRemove($path);
        Redirector::back()->redirect();

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