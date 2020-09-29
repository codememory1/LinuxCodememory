<?php

namespace System\Plugins;

use System\Plugins\PluginBasikFunctionsTrait;
use Store;
use Response;

/**
 * Trait MainTraitPluginFunctionality
 * @package System\Plugins
 */
trait MainTraitPluginFunctionality
{

	use PluginBasikFunctionsTrait;
	
	private static $PATCH_PLUGIN = 'CustomPlugin/';

    /**
     * @return mixed
     */
	public function executeAll()
	{
		
		foreach($this->getInstalled() as $installed)
		{
			
			if(array_key_exists($installed['plugin_name'], $this->getActive()[0]))
			{
				
				if(count($this->getAllError($installed['plugin_name'])) < 1)
				{
					$plgInfo = $this->getInfoPlugin($installed['plugin_name']);
				
					$patch = ($plgInfo->PluginSettings->PatchFileStart == '*') ? 
						self::$PATCH_PLUGIN.$installed['plugin_name'].'/'.$plgInfo->PluginSettings->FormatCreate :
						self::$PATCH_PLUGIN.$installed['plugin_name'].'/'.rtrim(ltrim($plgInfo->PluginSettings->PatchFileStart, '/'), '/').'/'.$plgInfo->PluginSettings->FormatCreate;
					$patch = str_replace('/', '\\', $patch);

					$newClassPlugin = new $patch();
					$funcExecutePlugin = (string) $plgInfo->PluginSettings->StartFunction;

					$newClassPlugin->$funcExecutePlugin();
				}
			}
		}
		
	}

    /**
     * @param $plugin_name
     * @param   string $status_plugin
     */
	public function controlStatusPlugin($plugin_name, $status_plugin = 'off')
	{
		
		if($status_plugin == 'off') {
			$this->statusOff($plugin_name, $status_plugin);
		}
		
		if($status_plugin == 'on') {
			$this->statusOn($plugin_name, $status_plugin);
		}
		
	}

    /**
     * @param $plugin_name
     * @param $status_plugin
     */
	private function statusOff($plugin_name, $status_plugin)
	{
		
		if(array_key_exists($plugin_name, $this->getActive()[0]))
		{
			if($this->getActive()[0][$plugin_name]['status'] === 1)
			{
				$active = $this->getActive();
				
				unset($active[0][$plugin_name]);

				Store::overwrite('system/Plugins/CustomPlugins/ActivePlugins', Response::arrayToJson($active), '.json');

			}
		}
		
	}

    /**
     * @param $plugin_name
     * @param $status_plugin
     */
	private function statusOn($plugin_name, $status_plugin)
	{
		
		if(!array_key_exists($plugin_name, $this->getActive()[0]))
		{
			$installPlg = [];
			
			foreach($this->getInstalled() as $installed)
			{
				$installPlg[$installed['plugin_name']] = $installed['plugin_name'];
			}
			
			if(array_key_exists($plugin_name, $installPlg))
			{
				$active = $this->getActive();
				$active[0] += [
					$plugin_name => [
						'status' => 1
					]
				];

				Store::overwrite('system/Plugins/CustomPlugins/ActivePlugins', Response::arrayToJson($active), '.json');	
			}
			
		}
		
	}

    /**
     * @param $plugin_name
     * @param   bool $status_install
     */
	public function installPlugin($plugin_name, $status_install = true)
	{
		
		$installedList = $this->getInstalled();
		
		if($status_install === false || $status_install == 'false') 
			$this->removePluginInsall($plugin_name, $installedList);
		
		if($status_install === true || $status_install == 'true')
			$this->installedPlugin($plugin_name, $installedList);
		
	}

    /**
     * @param $plugin_name
     * @param   array $installedList
     */
	private function installedPlugin($plugin_name, array $installedList)
	{
		
		$installPlg = [];
			
		foreach($installedList as $installed)
		{
			$installPlg[$installed['plugin_name']] = $installed['plugin_name'];
		}
		
		if(Store::isDir('system/Plugins/Plugins/'.$plugin_name))
		{
			if(!array_key_exists($plugin_name, $installPlg))
			{
				$installedList[] = [
					'plugin_name' => $plugin_name
				];

				Store::overwrite('system/Plugins/CustomPlugins/InstalledPlugins', Response::arrayToJson($installedList), '.json');	

			}
		}
		
	}

    /**
     * @param $plugin_name
     * @param   array $installedList
     */
	private function removePluginInsall($plugin_name, array $installedList)
	{
		
		$installPlg = [];
			
		foreach($installedList as $key => $installed)
		{
			$installPlg[$installed['plugin_name']] = $key;
			
			$this->statusOff($installed['plugin_name'], false);
		}
		
		if(Store::isDir('system/Plugins/Plugins/'.$plugin_name))
		{
			if(array_key_exists($plugin_name, $installPlg))
			{
				unset($installedList[$installPlg[$plugin_name]]);

				Store::overwrite('system/Plugins/CustomPlugins/InstalledPlugins', Response::arrayToJson($installedList), '.json');	

			}
		}
		
	}
	
}