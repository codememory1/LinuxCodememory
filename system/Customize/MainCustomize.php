<?php

namespace System\Customize;

use System\Customize\Exceptions\InvalidKeyCustomizeException;
use System\Customize\Exceptions\InvalidKeyCustomizeConfigException;
use File;
use Store;

/**
 * Trait MainCustomize
 * @package System\Customize
 */
class MainCustomize
{

    const PATCH_CUSTOMIZES = 'system.Customize.';
	const REGISTER_NAME_CONFIG = 'Config.';
	const REGISTER_NAME_CUSTOMIZE = 'Customize.';

    /**
     * @var array
     */
	private $customize = [];

    /**
     * @var array
     */
	private $dataCustomize = [];

    /**
     * @var array
     */
	private $nameCustomizeConfig = [];

    /**
     * @return string|string[]
     */
	private  static function patch()
	{
		
		$patch = str_replace('.', '/', self::PATCH_CUSTOMIZES);
		
		return $patch;
		
	}

    /**
     * @param $customize
     *
     * @return bool
     */
	public function hasCustomize($customize)
	{
		
		return 
			(Store::isDir($this->patch().self::REGISTER_NAME_CUSTOMIZE.$customize)) ?
			true :
		false;
		
	}

    /**
     * @param $customize
     * @param $config
     *
     * @return bool
     */
	public static function hasConfig($customize, $config)
	{
		
		return 
			(Store::exists(static::patch().self::REGISTER_NAME_CUSTOMIZE.$customize.'/'.
							self::REGISTER_NAME_CONFIG.$config.'.php')) ?
			true :
		false;
		
	}

    /**
     * @param $customize
     * @param $config
     *
     * @return bool
     */
	private function hasCustomizeArray($customize, $config)
	{
		
		if(!array_key_exists($customize, $this->customize))
		{
			throw new InvalidKeyCustomizeException($customize);
		}
		else
		{
			if(!array_key_exists($config, $this->customize[$customize]))
			{
				throw new InvalidKeyCustomizeConfigException($customize, $config);
			}
		}
		
		return true;
		
	}

    /**
     * @param $customize
     * @param $config
     *
     * @return mixed
     */
	private function handleGet($customize, $config)
	{
		
		$patch = str_replace('.', '/', self::PATCH_CUSTOMIZES);
		
		if($this->hasCustomize($customize) === true &&
		  $this->hasConfig($customize, $config) === true)
		{
			return File::import($patch.self::REGISTER_NAME_CUSTOMIZE.$customize.'/'.
								self::REGISTER_NAME_CONFIG.$config.'.php');
		}
		else
		{
			if($this->hasCustomizeArray($customize, $config) === true)
				return $this->dataCustomize[$customize][$config];
				
		}
		
	}

    /**
     * @param $customize
     * @param $config
     *
     * @return mixed
     */
	public function get($customize, $config)
	{
		
		return $this->handleGet($customize, $config);
		
	}

    /**
     * @param   array $data
     *
     * @return $this
     */
	public function data($data = [])
	{
		
		$this->dataCustomize[array_keys($this->nameCustomizeConfig)[0]][$this->nameCustomizeConfig[array_keys($this->nameCustomizeConfig)[0]]['config']] = $data;
		
		return $this;
		
	}

    /**
     * @param $customize
     * @param $config
     *
     * @return $this
     */
	public function set($customize, $config)
	{
		
		$this->customize[$customize][$config] = $this->dataCustomize;
		
		$this->nameCustomizeConfig = [
			$customize => [
				'config' => $config
			]
		];
		
		return $this;
		
	}
    
}