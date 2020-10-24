<?php

namespace App\Controllers;

use System\Codememory\AbstractComponent\Controller;

/**
 * Class
 * @package App\Consollers\StorageController
 */
class StorageController extends Controller
{
    
    /**
     * common
     *
     * @var mixed
     */
    private $common;

    /**
     * StorageController constructor.
     *
     * @param $container
     */
    public function __construct()
    {
        parent::__construct();

        $this->common = $this->model->load('Common');
    }

    public function view()
    {
        $storageModel = $this->model->load('Storage');
        $usersModel = $this->model->load('Users');

        $this->view->big('remote-data-storage', ['all' => $storageModel->getAll($usersModel)]);
        
    }
    
}