<?php

namespace System\Plugins;

use Store;
use Response;

/**
 * Trait PluginBasikFunctionsTrait
 * @package System\Plugins
 */
trait PluginBasikFunctionsTrait
{

    /**
     * @return mixed
     */
	public function all():array
	{
		
		return Store::scan('system/Plugins/Plugins');
		
	}

    /**
     * @return mixed
     */
	public function getActive():array
	{
		
		$plugin = Store::getApi('system/Plugins/CustomPlugins/ActivePlugins.json');
		return Response::jsonToArray($plugin);
		
	}

    /**
     * @return mixed
     */
	public function getInstalled():array
	{
		
		$plugin = Store::getApi('system/Plugins/CustomPlugins/InstalledPlugins.json');
		
		return Response::jsonToArray($plugin);
		
	}

    /**
     * @param $plugin
     *
     * @return \SimpleXMLElement|string[]
     */
	public function getInfoPlugin($plugin):object
	{
		
		if(Store::isDir('system/Plugins/Plugins/'.$plugin) && 
		  Store::exists('system/Plugins/Plugins/'.$plugin.'/InformationsPlugin.xml'))
		{
			return Store::xmlArray('system/Plugins/Plugins/'.$plugin.'/InformationsPlugin.xml');
		}
		
		return [ 'Error' ];
		
	}
	
	 /**
     * @return mixed
     */
	public function getNotActive():array
	{
		
		$all = $this->all();
		$active = [];
		
		foreach($this->getActive() as $plugin)
		{
			
			$active = $plugin;
			
		}
		
		$notActive = [];
		
		foreach($all as $pluginName)
		{
			
			if(!array_key_exists($pluginName, $active))
				$notActive[] = $pluginName;
			
		}
		
		return $notActive;
		
	}
	
}