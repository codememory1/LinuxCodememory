<?php

namespace System\Inc;

use Symfony\Component\Yaml\Yaml;
use Url;
use Store;

class FileYaml
{
	
	const EXPANSION_FILE = '.yaml';
		
	/**
	 * open
	 *
	 * @var mixed
	 */
	private $open;
		
	/**
	 * path
	 *
	 * @param  mixed $path
	 * @return void
	 */
	private function path($path)
	{
		
		return Url::join($path);
		
	}
		
	/**
	 * open
	 *
	 * @param  mixed $file
	 * @return void
	 */
	public function open(string $file)
	{
		
		$this->open = $file;
		
		return $this;
		
	}
		
	/**
	 * parse
	 *
	 * @param  mixed $option
	 * @return void
	 */
	public function parse($option = null)
	{
		
		return Yaml::parseFile($this->path($this->open.self::EXPANSION_FILE));
		
	}
	
	public function write(array $data, $option = null)
	{
		
		
		
	}
	
}