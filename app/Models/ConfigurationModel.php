<?php

namespace App\Models;

use System\Codememory\RegisterService;
use App\Models\stdConfiguration;
use App\Models\Repositories\ConfigurationRepository;
use Store;

/**
 * ConfigurationModel
 */
class ConfigurationModel extends RegisterService
{

    /**
     * std
     *
     * @var mixed
     */
    private $std;
    
    /**
     * conf
     *
     * @var mixed
     */
    private $conf;
    
    /**
     * notTuned
     *
     * @var array
     */
    private $notTuned = [];
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        
        parent::__construct();

        $this->std = new stdConfiguration();
        $this->conf = new ConfigurationRepository();
        $this->std->allSettings = 0;

        $this->setConf();


        $this->checkConfiguration();
    }
    
    /**
     * setConfDirs
     *
     * @return void
     */
    private function setConf()
    {

        $path = sprintf('FastDB/Servers/%s/', $this->conf->getFullServer('server-dir'));
        $representationPath = sprintf('Representation/%s/', $this->conf->getUsername());

        $this->std->configuration = [
            'dirs' => [
                $path.$representationPath,
                $path.$representationPath.'Event_Auth',
                $path.$representationPath.'Event_CreateTable',
                $path.$representationPath.'Event_CreateDatabase',
                $path.$representationPath.'Event_AddRecord',
                $path.$representationPath.'Event_DeleteRecord',
                $path.sprintf('Databases/%s', $this->conf->getUsername()),
                $path.sprintf('Users/%s/History', $this->conf->getUsername()),
            ]
        ];

        $this->std->allSettings += 8;

    }
    
    /**
     * customizeConfiguration
     *
     * @return void
     */
    public function customizeConfiguration()
    {

        foreach($this->notTuned['dirs'] as $dir)
        {
            if(!Store::isDir($dir)) {
                Store::createDir($dir);
            }
        }

    }
    
    /**
     * checkConfiguration
     *
     * @return void
     */
    private function checkConfiguration()
    {

        if(array_key_exists('dirs', $this->std->configuration) && ($this->std->configuration['dirs'] !== [])) {
            foreach($this->std->configuration['dirs'] as $dir)
            {
                if(Store::isDir($dir) === false) {
                    $this->notTuned['dirs'][] = $dir;
                }
            }
        }

        if(array_key_exists('files', $this->std->configuration) && ($this->std->configuration['files'] !== [])) {
            foreach($this->std->configuration['files'] as $file)
            {
                if(Store::exists($file) === false) {
                    $this->notTuned['files'][] = $file;
                }
            }
        }

    }
    
    /**
     * getNotTuned
     *
     * @return array
     */
    public function getNotTuned():array
    {

        return $this->notTuned;

    }
    
    /**
     * getPercentageConfigSetting
     *
     * @return int
     */
    public function getPercentageConfigSetting():int
    {

        $notTunedDirs = array_key_exists('dirs', $this->getNotTuned()) ? count($this->getNotTuned()['dirs']) : 0;
        $notTunedFiles = array_key_exists('files', $this->getNotTuned()) ? count($this->getNotTuned()['files']) : 0;
        $allNot = $notTunedDirs + $notTunedFiles;

        return ($this->std->allSettings - $allNot) / $this->std->allSettings * 100;

    }

}