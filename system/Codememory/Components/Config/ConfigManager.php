<?php

namespace System\Codememory\Components\Config;

use System\Codememory\Components\Config\Exceptions\InvalidConfigException;
use System\Codememory\Components\Config\Exceptions\InvalidKeyInConfigException;
use Store;
use File;

class ConfigManager
{
    
    const PATCH_CONFIGS = 'config/';
	
	private $data = [];
	
	private $configs = [];
	
	private $configName;
	
	/* Открыть файл конфиг, или анонимный конфиг */
	public function open($config)
	{
		
		$conf = Store::replace(['.' => '/'], $config);
		
		$this->configName = $config;
		
		if($this->exists($config) === false && $this->existsAnonymous($config) === false)
			throw new InvalidConfigException($config);
		else
			$this->data = ($this->exists($conf) === true) ? 
				File::import(static::PATCH_CONFIGS.$conf.'.php') :
					$this->configs[$conf];
		
		return $this;
		
	}
	
	/* Проверка существование конфига */
	public function exists($config)
	{
		
		$conf = Store::replace(['.' => '/'], $config);
		
		return 
			(Store::exists(static::PATCH_CONFIGS.$conf.'.php')) ? 
			true : 
		false;
		
	}
	
	/* Проверка существование анонимного кофига */
	private function existsAnonymous($config)
	{

		return 
			(array_key_exists($config, $this->configs)) ? 
			true : 
		false;
		
	}
	
	/* Получение данных из файла конфига */
	public function get()
	{
		
		return $this->data;
		
	}
	
	/* Получение данных из конфига по ключу */
	public function data($data)
	{
		
		if(!array_key_exists($data, $this->data))
			throw new InvalidKeyInConfigException($this->configName, $data);
		else
			$this->data = $this->data[$data];
		
		return $this;
		
	}
    
	/* Создание анонимного конфига с данными */
	public function set($config, array $data = [])
	{

		$this->configs[$config] = $data;
		
		return $this;
		
	}
	
}