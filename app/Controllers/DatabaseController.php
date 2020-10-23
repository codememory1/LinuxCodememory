<?php

namespace App\Controllers;

use System\Codememory\AbstractComponent\Controller;
use App\Models\Repositories\ConfigurationRepository;
use App\Models\Repositories\DocumentationRepository;
use Response;

/**
 * Class
 * @package App\Consollers\DatabaseController
 */
class DatabaseController extends Controller
{
        
    /**
     * dbModel
     *
     * @var mixed
     */
    private $dbModel;

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
        $this->dbModel = $this->model->load('Database');
    }
    
    /**
     * allDb
     *
     * @return void
     */
    public function allDb()
    {

        $this->view->big('all-database', ['del_db' => $this->common->getAccess('delete-db'), 'all' => $this->dbModel->listWithTables()]);
        
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
            
            $reprModel = $this->model->load('Representation');

            if($this->common->invalidToken() === true)
            {
                $this->dbModel->createDatabase($reprModel);
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

            $this->dbModel->deleteDatabase($this->request->get('dbname'));
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
            $tables = $this->dbModel->listWithTables()[$this->request->get('dbname')];

            $this->view->big('open-db', ['tables' => $tables]);
        }
        else {
            Response::setResponseCode(404)
				->getContentResponseCode();
        }

    }
    
    /**
     * docs
     *
     * @param  mixed $link
     * @return void
     */
    public function docs($link)
    {
        
        $repository = new DocumentationRepository();

        $this->view->big('doc', ['menu' => $repository->getSitebarMenu()]);

    }
    
    /**
     * console
     *
     * @return void
     */
    public function console()
    {

        $this->view->big('console');

    }
    
    /**
     * representation
     *
     * @return void
     */
    public function representation()
    {

        $model = $this->model->load('Representation');
        $conf = $this->model->load('Configuration');

        $this->view->big('representation', ['getRepr' => $model->getAll()]);

    }
    
    /**
     * representationHandler
     *
     * @return void
     */
    public function representationHandler()
    {

        $model = $this->model->load('Representation');

        if($this->common->memoryCheck()) {
            $model->create();
        }

    }
    
    /**
     * customizeConfig
     *
     * @return void
     */
    public function customizeConfig()
    {

        $conf = $this->model->load('Configuration');

        if($conf->getPercentageConfigSetting() < 100) {
            $conf->customizeConfiguration();
        }

        \Redirector::back()->redirect();

    }
    
    
}