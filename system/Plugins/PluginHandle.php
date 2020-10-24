<?php

namespace System\Plugins;

use System\Plugins\MainTraitPluginFunctionality;
use System\Plugins\CommonErrorsPlugins\CheckFileInformationError;
use System\Plugins\CommonErrorsPlugins\InvalidKeyInformationPlugin;
use System\Plugins\CommonErrorsPlugins\InvalidKeySettingsPlugin;
use System\Plugins\CommonErrors;
use Store;

/**
 * Class PluginHandle
 * @package System\Plugins
 */
class PluginHandle
{
	
	use MainTraitPluginFunctionality;
	
	const PATCH_PLUGINS = 'system.Plugins.Plugins.';

    /**
     * @var array
     */
	private $errors = [];

    /**
     * @var string[]
     */
	private $keyXmlInfo = [
		'namePlugin', 'Description', 'PluginTask', 'Version', 'Author', 'EmailAuthorPlugin', 'ReleaseDate', 'PluginSettings'
	];

    /**
     * @var string[]
     */
	private $keyXmlInfoSettings = [
		'StartFunction', 'FormatCreate', 'PatchFileStart'
	];

    /**
     * @return string|string[]
     */
	private function patch()
	{
		
		return str_replace('.', '/', self::PATCH_PLUGINS);
		
	}

    /**
     * @param $plugin
     *
     * @return array
     */
	public function getAllError($plugin):array
	{

		$this->checkInfoFile($plugin);
		$this->checkParamInfoXml($plugin);
		
		return (array) $this->errors;
		
	}

    /**
     * @param $plugin
     */
	private function checkParamInfoXml($plugin)
	{
		
		$info = (array) $this->getInfoPlugin($plugin);
		
		foreach($this->keyXmlInfo as $keyXml)
		{
			if(!array_key_exists($keyXml, $info))
				$this->errors['ERR_INFO_PLUGIN'] = new InvalidKeyInformationPlugin();
		}
		
		foreach($this->keyXmlInfoSettings as $settingsPluginXml)
		{
			if(!array_key_exists($settingsPluginXml, $info['PluginSettings']))
				$this->errors['ERR_SETTINGS_PLUGIN'] = new InvalidKeySettingsPlugin($settingsPluginXml);
		}
		
	}

    /**
     * @param $plugin
     */
	private function checkInfoFile($plugin)
	{
		
		if(Store::isDir($this->patch().$plugin))
		{
			($this->checkFileInfoPlugin($plugin) === false) ?
				$this->errors['ERR_FILE_INFO_PLUGIN'] = new CheckFileInformationError() : 
			false;
		}
		
	}

    /**
     * @param $plugin
     *
     * @return bool
     */
	private function checkFileInfoPlugin($plugin)
	{
		
		return (Store::exists($this->patch().$plugin.'/InformationsPlugin.xml')) ? true : false;
		
	}
	
}