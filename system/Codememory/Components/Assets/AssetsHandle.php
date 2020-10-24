<?php

namespace System\Codememory\Components\Assets;

use Url;
use Store;
use Response;

/**
 * AssetsHandle
 */
class AssetsHandle
{
		
	/**
	 * path
	 *
	 * @var mixed
	 */
	private $path;
		
	/**
	 * __construct
	 *
	 * @param  mixed $path
	 * @return void
	 */
	public function __construct($path)
	{
		
		$this->path = $path;
		
	}
		
	/**
	 * readHash
	 *
	 * @param  mixed $file
	 * @return void
	 */
	private function readHash(string $file)
	{
		
		$file = Store::getApi($this->path.$file);
		$hash = md5($file);
		
		return '?v='.$hash;
		
	}
		
	/**
	 * list
	 *
	 * @param  mixed $dir
	 * @param  mixed $expansion
	 * @return void
	 */
	public function list(string $dir, string $expansion)
	{
		
		$list = Store::scan($this->path.$expansion.'/'.$dir);
		
		$newList = [];
		if(count($list) > 0)
		{
			foreach($list as $app)
			{
				if(Store::isFile($this->path.$expansion.'/'.$dir.'/'.$app))
				{
					$partFile = explode('.'.$expansion, $app);

					(pathinfo(Url::join($this->path.$dir.'/'.$app))['extension'] == $expansion) ? $newList[$partFile[0]] = $partFile[0] : false;
	
				}
			}
		}
		
		return $newList;
		
	}
		
	/**
	 * css
	 *
	 * @param  mixed $file
	 * @return void
	 */
	public function css(string $file, array $attributes = [])
	{
		
		$file = 'css/'.$file.'.css';
		$attr = null;

		if(count($attributes) > 0) {
			foreach($attributes as $attr => $value)
			{
				$attr .= $attr.'="'.$value.'" ';
			}
		}
		
		$css = sprintf('<link rel="stylesheet" href="%s" '.$attr.'>', $this->path.$file.$this->readHash($file));
		
		return Response::setContent($css)->sendContent();
		
	}
		
	/**
	 * js
	 *
	 * @param  mixed $file
	 * @return void
	 */
	public function js(string $file, array $attributes = []) 
	{
		
		$file = 'js/'.$file.'.js';

		$attr = null;

		if(count($attributes) > 0) {
			foreach($attributes as $attr => $value)
			{
				$attr .= $attr.'="'.$value.'" ';
			}
		}
		
		$css = sprintf('<script src="%s" '.$attr.'></script>', $this->path.$file.$this->readHash($file));
		
		return Response::setContent($css)->sendContent();
		
	}
		
	/**
	 * all
	 *
	 * @param  mixed $dir
	 * @param  mixed $sort
	 * @param  mixed $file
	 * @return void
	 */
	private function all(string $dir, array $sort, string $file)
	{
		
		$allCss = null;
		
		if(count($sort) > 0)
		{
			$allCss = null;
			
			foreach($sort as $css)
			{
				$allCss .= $this->$file($dir.'/'.$css);
			}
		}
		else 
		{
			$allCss = null;
			foreach($this->list($dir, $file) as $css)
				$allCss .= $this->$file($dir.'/'.$css);
		}
		
		return $allCss;
		
	}
		
	/**
	 * allCss
	 *
	 * @param  mixed $dir
	 * @param  mixed $sort
	 * @return void
	 */
	public function allCss(string $dir, array $sort = [])
	{
		
		return $this->all($dir, $sort, 'css');
		
	}
		
	/**
	 * allJs
	 *
	 * @param  mixed $dir
	 * @param  mixed $sort
	 * @return void
	 */
	public function allJs(string $dir, array $sort = [])
	{
		
		return $this->all($dir, $sort, 'js');
		
	}
	
}