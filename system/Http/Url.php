<?php

namespace System\Http;

use Store;
use Response;
use Ini;

/**
 * Url
 */
class Url
{
		
	/**
	 * defaultPath
	 *
	 * @return void
	 */
	public function defaultPath()
	{
		
		Ini::setCfg('include_path', $this->rootPath());
		
	}
		
	/**
	 * rootPath
	 *
	 * @return void
	 */
	public function rootPath() 
	{
		
		return Store::replace(['/' => '\\'], dirname(dirname(__DIR__))).'\\';
		
	}
	
	/**
	 * selfPath
	 *
	 * @return void
	 */
	public function selfPath()
	{
		
		return $this->rootPath().'src/';
		
	}
		
	/**
	 * join
	 *
	 * @param  mixed $path
	 * @return void
	 */
	public function join(string $path)
	{
		
		$path = Store::replace(['/' => '\\'], $path);

		return $this->rootPath().trim($path, '/');
		
	}
		
	/**
	 * pathAllRootFolders
	 *
	 * @param  mixed $folder
	 * @return void
	 */
	public function pathAllRootFolders($folder = null)
	{
		
		$all = Store::scan('/');
		
		$folders = [];
		
		foreach($all as $v)
		{
			if(Store::isDir($v) === true)
				$folders[$v] = $this->join($v);
		}
		
		return (array_key_exists($folder, $folders) && $folder !== null && $folders != '') ? $folders[$folder] : $folders;
		
	}
	
}
