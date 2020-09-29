<?php

namespace System\Codememory;

use System\Plugins\PluginHandle;
use System\Support\Session\ServerSession;
use System\Codememory\AbstractComponent\ControllersObserver\Observer;
use File;

/**
 * Class CodememoryContainer
 * @package System\Codememory
 */
class CodememoryContainer
{

    /**
     * @var array
     */
	public $services = [];

	/*
	 * Render Service Provider
	 *
	 */
	public function generateServices()
	{
		
		$services = require dirname(__DIR__) . '/../config/service.php';
		
		foreach($services as $k => $service)
		{
			
			$classService = new $service();
			$installService = $classService->init();
			
			$this->services[$classService->nameService] = $installService->cm->services[$classService->nameService];
			
		}
		
		(object) $this->services;
		
	}

    /**
     * @param $service
     *
     * @return mixed
     */
	public function get($service)
	{
		
		return $this->services->$service;
		
	}

    /**
     * @param $key
     * @param $data
     */
	public function set($key, $data)
	{
		
		$this->services[$key] = $data;
		
	}

    /**
     * Render ENV settings file
     *
     */
	private function runEnvSettings()
	{
		
		require dirname(__DIR__) . '/../config/app.php';
		
	}

    /**
     * Render Facade and Alias
     *
     */
	private function renderFacades()
	{
		
		new Facade();
		new AliasesContainer();
		
		Facade::installStaticMethod();
		AliasesContainer::getList();
		
	}

	private function settingsConfiguration()
	{

		require include_cm('config/Codememory/configuration');

		session_save_path(\Url::join($session['save']));
		
	}

    /**
     * Start Conatiner
     *
     */
	public function runFramework()
	{
		$this->settingsConfiguration();

		session_start();

		$this->runEnvSettings();
		$this->generateServices();
		
		$plugin = new PluginHandle();
		$plugin->executeAll();

		$this->services['router']->routeStart($this);
		
		
	}
	
}