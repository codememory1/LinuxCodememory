<?php

namespace App\Controllers;

use System\Codememory\AbstractComponent\Controller;

/**
 * Class
 * @package App\Consollers\SettingsController
 */
class SettingsController extends Controller
{
    
    /**
     * common
     *
     * @var mixed
     */
    private $common;

    /**
     * SettingsController constructor.
     *
     * @param $container
     */
    public function __construct()
    {
        parent::__construct();

        $this->common = $this->model->load('Common');
    }
    
    /**
     * saveingDeletedData
     *
     * @return void
     */
    public function saveingDeletedData()
    {

        $reqAs = $this->request->post('as-save-deleted-data');
        $as = $reqAs != 'server' && $reqAs != 'local' ? 'server' : $reqAs;
        $model = $this->model->load('Settings');

        $model->editAsSavingDeletedData($as);

    }
    
    /**
     * turnDeletedData
     *
     * @return void
     */
    public function turnDeletedData()
    {

        $req = $this->request->post('save-deleted-data') == 'on' ? true : false;
        $model = $this->model->load('Settings');

        $model->turnSaveDeletedData($req);

    }
    
}