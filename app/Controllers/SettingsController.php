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
     * settingsModel
     *
     * @var mixed
     */
    private $settingsModel;

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
        $this->settingsModel = $this->model->load('Settings');
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

        $this->settingsModel->editAsSavingDeletedData($as);

    }
    
    /**
     * turnDeletedData
     *
     * @return void
     */
    public function turnDeletedData()
    {

        $req = $this->request->post('save-deleted-data') == 'on' ? true : false;

        $this->settingsModel->turnSaveDeletedData($req);

    }

    /**
     * settings
     *
     * @return void
     */
    public function settings()
    {
        $usersModel = $this->model->load('Users');

        $this->view->big('settings', ['userdata' => $usersModel->getInfoUserCurrent()]);

    }
    
    /**
     * updateUserToken
     *
     * @return void
     */
    public function updateUserToken()
    {

        $this->settingsModel->updateToken();

    }

    public function save()
    {

        $this->settingsModel->saveUserSettings();

    }
    
}