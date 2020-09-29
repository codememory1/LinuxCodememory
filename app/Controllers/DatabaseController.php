<?php

namespace App\Controllers;

use System\Codememory\AbstractComponent\Controller;
use App\Models\Repositories\ConfigurationRepository;
use Response;

/**
 * Class
 * @package App\Consollers\DatabaseController
 */
class DatabaseController extends Controller
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
     * allDb
     *
     * @return void
     */
    public function allDb()
    {

        $modelDb = $this->model->load('Database');

        $this->view->big('all-database', ['del_db' => $this->common->getAccess('delete-db'), 'all' => $modelDb->listWithTables()]);
        
    }
    
    /**
     * createDb
     *
     * @return void
     */
    public function createDb()
    {

        $this->common->checkAccess('create-db');

        $this->view->big('create-database');

    }
    
    /**
     * createDbHandler
     *
     * @return void
     */
    public function createDbHandler()
    {

        $this->common->checkAccess('create-db');
        if($this->common->memoryCheck() === true) {   
            $model = $this->model->load('Database');

            if($this->common->invalidToken() === true)
            {
                $model->createDatabase();
            }
        }

    }
    
    /**
     * deleteDb
     *
     * @return void
     */
    public function deleteDb() 
    {

        $this->common->checkAccess('delete-db');

        if($this->common->existsDb($this->request->get('dbname')) === true) {
            $model = $this->model->load('Database');

            $model->deleteDatabase($this->request->get('dbname'));
        }
        else {
            Response::setResponseCode(404)
				->getContentResponseCode('Not Found');
        }

    }
    
    /**
     * additionalMemory
     *
     * @return void
     */
    public function additionalMemory()
    {

        $this->view->big('bye-memory');

    }
    
    /**
     * open
     *
     * @return void
     */
    public function open()
    {

        if($this->common->existsDb($this->request->get('dbname')) === true) {
            $modelDb = $this->model->load('Database');
            $tables = $modelDb->listWithTables()[$this->request->get('dbname')];

            $this->view->big('open-db', ['tables' => $tables]);
        }
        else {
            Response::setResponseCode(404)
				->getContentResponseCode();
        }

    }
    
}