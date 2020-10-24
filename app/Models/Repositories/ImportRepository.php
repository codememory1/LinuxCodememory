<?php

namespace App\Models\Repositories;

use App\Models\CommonModel;
use App\Models\Repositories\ConfigurationRepository;
use Model;
use System\Codememory\RegisterService;

/**
 * ConfigurationRepository
 */
class ImportRepository extends RegisterService
{
        
    /**
     * common
     *
     * @var mixed
     */
    private $common;
    
    /**
     * configurationRepository
     *
     * @var mixed
     */
    private $configurationRepository;
    
    /**
     * __constructor
     *
     * @return void
     */
    public function __construct()
    {

        parent::__construct();

        $this->common = new CommonModel();
        $this->configurationRepository = new ConfigurationRepository();

    }
    
    /**
     * getCommon
     *
     * @return void
     */
    public function getCommon()
    {

        return new CommonModel();

    }
    
    /**
     * getModel
     *
     * @param  mixed $model
     * @return void
     */
    public function getModel(string $model)
    {

        return Model::load($model);

    }
    
    /**
     * getConfig
     *
     * @return void
     */
    public function getConfig()
    {

        return $this->configurationRepository;

    }

}