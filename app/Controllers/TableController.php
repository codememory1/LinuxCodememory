<?php

namespace App\Controllers;

use System\Codememory\AbstractComponent\Controller;
use App\Models\Repositories\ConfigurationRepository;
use GuzzleHttp\Exception\ClientException;
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
     * tableModel
     *
     * @return void
     */
    private function tableModel()
    {

        return $this->model->load('Tables');

    }

    private function basicData(?string $method = 'get')
    {

        $dbname = $this->request->$method('dbname');
        $table = $this->request->$method('table');

        return [
            'model'  => $this->tableModel(),
            'dbname' => $dbname,
            'table'  => $table
        ];

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
            Response::setResponseCode(200);

            $this->tableModel()->createTable();
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
        $dbname = $this->request->get('dbname');
        $table = $this->request->get('table');

        if($this->common->existsTable($dbname, $table) === false) {
            Response::setResponseCode(404)
                    ->getContentResponseCode('Not Found');
        } else {
            $this->tableModel()->delete($dbname, $table);
        }

    }
    
    /**
     * settings
     *
     * @return void
     */
    public function settings()
    {

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

        $dbname = $this->request->get('dbname');
        $table = $this->request->get('table');

        if($this->common->existsTable($dbname, $table) === false) {
            Response::setResponseCode(404)
                    ->getContentResponseCode('Not Found');
        } else {
            $this->tableModel()->settingsTable($dbname, $table, $this->request->post('dbname'), $this->request->post('table-name'));
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

        if($this->common->existsTable($dbname, $table) === false) {
            Response::setResponseCode(404)
                    ->getContentResponseCode('Not Found');
        } 

        $this->view->big('watch-table', 
            [
                'dbname'    => $dbname, 
                'table'     => $table, 
                'structure' => $this->tableModel()->getStructure($dbname, $table),
                'datas'     => $this->tableModel()->getData($dbname, $table)
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

        $dbname = $this->request->get('dbname');
        $table = $this->request->get('table');
        
        if($this->common->existsTable($dbname, $table) === false) {
            Response::setResponseCode(404)
                    ->getContentResponseCode('Not Found');
        }

        $this->tableModel()->cleansTable($dbname, $table);

    }

    /**
     * deleteSelection
     *
     * @return void
     */
    public function deleteSelection()
    {

        $this->common->checkAccess('cleans-table');

        $dbname = $this->request->get('dbname');
        $table = $this->request->get('table');

        if($this->common->existsTable($dbname, $table) === false) {
            Response::setResponseCode(404)
                    ->getContentResponseCode('Not Found');
        } 

        $this->tableModel()->deleteTableData($dbname, $table);

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
        
        if($this->common->existsTable($dbname, $table) === false) {
            Response::setResponseCode(404)
                    ->getContentResponseCode('Not Found');
        }

        $this->view->big('embed-data-table', [
            'structure' => $this->tableModel()->getStructure($dbname, $table),
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

        $dbname = $this->request->get('dbname');
        $table = $this->request->get('table');
        
        if($this->common->existsTable($dbname, $table) === false) {
            Response::setResponseCode(404)
                    ->getContentResponseCode('Not Found');
        }

        if($this->common->memoryCheck() === true && $this->common->invalidToken() === true) {  
            $this->tableModel()->embedData($dbname, $table);
        }

    }
        
    /**
     * editData
     *
     * @return void
     */
    public function editData()
    {
        
        $this->common->checkAccess('edit-tabel-data');

        $dbname = $this->request->get('dbname');
        $table = $this->request->get('table');
        $id = $this->request->get('id');

        if($this->common->existsTable($dbname, $table) === false || !$this->tableModel()->getData($dbname, $table)['data'][$id]) {
            Response::setResponseCode(404)
                    ->getContentResponseCode('Not Found');
        }

        $this->view->big('edit-table-data', [
            'structure' => $this->tableModel()->getData($dbname, $table)['data'][$id],
        ]);

    }
    
    /**
     * editDataHandler
     *
     * @return void
     */
    public function editDataHandler()
    {

        $this->common->checkAccess('edit-tabel-data');

        $dbname = $this->request->get('dbname');
        $table = $this->request->get('table');
        $id = $this->request->get('id');

        if($this->common->existsTable($dbname, $table) === false || !$this->tableModel()->getData($dbname, $table)['data'][$id]) {
            Response::setResponseCode(404)
                    ->getContentResponseCode('Not Found');
        }

        if($this->common->memoryCheck() === true && $this->common->invalidToken() === true) {  
            $this->tableModel()->editData($dbname, $table, $id);
        }

    }
    
    /**
     * editStructure
     *
     * @return void
     */
    public function editStructure()
    {

        $this->common->checkAccess('create-table');

        $dbname = $this->request->get('dbname');
        $table = $this->request->get('table');

        if($this->common->existsTable($dbname, $table) === false) {
            Response::setResponseCode(404)
                    ->getContentResponseCode('Not Found');
        }

        $this->view->big('edit-structure', [
            'structure' => $this->tableModel()->getStructure($dbname, $table),
        ]);

    }
    
    /**
     * editStructureHandler
     *
     * @return void
     */
    public function editStructureHandler()
    {

        $this->common->checkAccess('create-table');

        $dbname = $this->request->get('dbname');
        $table = $this->request->get('table');

        if($this->common->existsTable($dbname, $table) === false) {
            Response::setResponseCode(404)
                    ->getContentResponseCode('Not Found');
        }

        $this->tableModel()->editStructure($dbname, $table);

    }

}