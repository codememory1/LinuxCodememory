<?php

namespace System\Inc;

use Url;
use Store;

/**
 * FileIni
 */
class FileIni
{
	
	const EXPANSION = '.ini';
		
	/**
	 * parseData
	 *
	 * @var array
	 */
	private $parseData = [];
		
	/**
	 * path
	 *
	 * @param  mixed $path
	 * @return void
	 */
	public function path($path)
	{
		
		return Url::join($path);
		
	}
		
	/**
	 * exists
	 *
	 * @param  mixed $path
	 * @return void
	 */
	public function exists($path)
	{
		
		return Store::exists($path.self::EXPANSION);
		
	}
		
	/**
	 * getValCfg
	 *
	 * @param  mixed $name
	 * @return void
	 */
	public function getValCfg($name)
	{
		
		return get_cfg_var($name);
		
	}
		
	/**
	 * getCfgAll
	 *
	 * @return void
	 */
	public function getCfgAll()
	{
		
		return ini_get_all();
		
	}
		
	/**
	 * setCfg
	 *
	 * @param  mixed $name
	 * @param  mixed $value
	 * @return void
	 */
	public function setCfg($name, $value)
	{
		
		return ini_set($name, $value);
		
	}
		
	/**
	 * parse
	 *
	 * @param  mixed $path
	 * @param  mixed $process
	 * @param  mixed $options
	 * @return void
	 */
	public function parse($path, $process = true, $options = null)
	{

		if($this->exists($path) === true) 
			$this->parseData = parse_ini_file($this->path($path.self::EXPANSION), $process, $options);
		
		return $this;
		
	}
		
	/**
	 * data
	 *
	 * @param  mixed $key
	 * @return void
	 */
	public function data($key = null)
	{
		
		$data = $this->parseData;
		
		if($key !== null)
		{
			$keys = explode('.', $key);

			foreach($keys as $vKey)
			{
				$data = $data[$vKey];
			}
		}
		
		return $data;
		
	}
	
}