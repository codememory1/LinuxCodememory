<?php

namespace App\Controllers;

use System\Codememory\AbstractComponent\Controller;
use App\Models\Repositories\ConfigurationRepository;
use Response;

/**
 * Class
 * @package App\Consollers\TableController
 */
class TableController extends Controller
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
     * createTable
     *
     * @return void
     */
    public function createTable()
    {
        
        $this->common->checkAccess('create-table');

        if($this->common->existsDb($this->request->get('dbname')) === false) {
            Response::setResponseCode(404)
				->getContentResponseCode('Not Found');
        }
        
        $this->view->big('create-table');
        
    }
    
    /**
     * createTablebHandler
     *
     * @return void
     */
    public function createTablebHandler()
    {

        $this->common->checkAccess('create-table');

        if($this->common->existsDb($this->request->get('dbname')) === false) {
            Response::setResponseCode(404)
				->getContentResponseCode('Not Found');
        }

        if($this->common->memoryCheck() === true) {  
            $model = $this->model->load('Tables');
            $model->createTable();
        }

    }
    
    /**
     * delete
     *
     * @return void
     */
    public function delete()
    {

        $this->common->checkAccess('delete-table');
        $model = $this->model->load('Tables');
        $dbname = $this->request->get('dbname');
        $table = $this->request->get('table');

        if($this->common->existsTable($dbname, $table) === false) {
            Response::setResponseCode(404)
                    ->getContentResponseCode('Not Found');
        } else {
            $model->delete($dbname, $table);
        }

    }
    
    /**
     * settings
     *
     * @return void
     */
    public function settings()
    {

        $model = $this->model->load('Tables');
        $modelDb = $this->model->load('Database');
        $dbname = $this->request->get('dbname');
        $table = $this->request->get('table');

        if($this->common->existsTable($dbname, $table) === false) {
            Response::setResponseCode(404)
                    ->getContentResponseCode('Not Found');
        } else {
            $this->view->big('settings-table', ['allDb' => array_keys($modelDb->listWithTables())]);
        }

    }
    
    /**
     * settingsHandler
     *
     * @return void
     */
    public function settingsHandler()
    {

        $model = $this->model->load('Tables');
        $dbname = $this->request->get('dbname');
        $table = $this->request->get('table');

        if($this->common->existsTable($dbname, $table) === false) {
            Response::setResponseCode(404)
                    ->getContentResponseCode('Not Found');
        } else {
            $model->settingsTable($dbname, $table, $this->request->post('dbname'), $this->request->post('table-name'));
        }
        

    }
    
    /**
     * watch
     *
     * @param  mixed $dbname
     * @param  mixed $table
     * @return void
     */
    public function watch($dbname, $table)
    {

        $this->common->checkAccess('watch-table');
        $model = $this->model->load('Tables');

        if($this->common->existsTable($dbname, $table) === false) {
            Response::setResponseCode(404)
                    ->getContentResponseCode('Not Found');
        } 

        $this->view->big('watch-table', 
            [
                'dbname'    => $dbname, 
                'table'     => $table, 
                'structure' => $model->getStructure($dbname, $table),
                'datas'     => $model->getData($dbname, $table)
            ]);

    }
        
    /**
     * cleans
     *
     * @return void
     */
    public function cleans()
    {

        $this->common->checkAccess('cleans-table');
        $model = $this->model->load('Tables');
        $dbname = $this->request->get('dbname');
        $table = $this->request->get('table');
        
        if($this->common->existsTable($dbname, $table) === false) {
            Response::setResponseCode(404)
                    ->getContentResponseCode('Not Found');
        }

        $model->cleansTable($dbname, $table);

    }

    /**
     * deleteSelection
     *
     * @return void
     */
    public function deleteSelection()
    {

        $this->common->checkAccess('cleans-table');

        $model = $this->model->load('Tables');
        $dbname = $this->request->get('dbname');
        $table = $this->request->get('table');

        if($this->common->existsTable($dbname, $table) === false) {
            Response::setResponseCode(404)
                    ->getContentResponseCode('Not Found');
        } 

        $model->deleteTableData($dbname, $table);

    }
    
    /**
     * embed
     *
     * @return void
     */
    public function embed()
    {

        $this->common->checkAccess('embed-data-table');

        $dbname = $this->request->get('dbname');
        $table = $this->request->get('table');
        $model = $this->model->load('Tables');
        
        if($this->common->existsTable($dbname, $table) === false) {
            Response::setResponseCode(404)
                    ->getContentResponseCode('Not Found');
        }

        $this->view->big('embed-data-table', [
            'structure' => $model->getStructure($dbname, $table),
        ]);

    }
    
    /**
     * embedHandler
     *
     * @return void
     */
    public function embedHandler()
    {

        $this->common->checkAccess('embed-data-table');

        $model = $this->model->load('Tables');
        $dbname = $this->request->get('dbname');
        $table = $this->request->get('table');
        
        if($this->common->existsTable($dbname, $table) === false) {
            Response::setResponseCode(404)
                    ->getContentResponseCode('Not Found');
        }

        if($this->common->memoryCheck() === true) {  
            $model->embedData($dbname, $table);
        }

    }
    
    public function editData()
    {

        // $this->common->checkAccess('edit-tabel-data');

        $model = $this->model->load('Tables');
        $dbname = $this->request->get('dbname');
        $table = $this->request->get('table');
        $id = $this->request->get('id');

        if($this->common->existsTable($dbname, $table) === false || !$model->getData($dbname, $table)['data'][$id]) {
            Response::setResponseCode(404)
                    ->getContentResponseCode('Not Found');
        }

        $this->view->big('edit-table-data', [
            'structure' => $model->getData($dbname, $table)['data'][$id],
        ]);

    }

}