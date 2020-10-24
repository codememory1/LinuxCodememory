<?php

namespace System\Inc;

use Url;

class File
{
		
	/**
	 * ignoresPath
	 *
	 * @var mixed
	 */
	private $ignoresPath = [];
	
	/**
	 * serahced
	 *
	 * @var array
	 */
	private $searched = [];

	/**
	* Полный путь до определеной папки или файла
	*/	
	/**
	 * path
	 *
	 * @param  mixed $path
	 * @return string
	 */
	private function path($path):string
	{
		
		return dirname(getcwd()).'/'.$path;
		
	}
	
	/**
	* Является ли это файлом
	*/	
	/**
	 * is
	 *
	 * @param  mixed $path
	 * @return bool
	 */
	public function is($path):bool
	{
		
		return (is_file($this->path($path)) === true) ? true : false;
		
	}
	
	/**
	* Существует ли данный файл
	*/	
	/**
	 * exists
	 *
	 * @param  mixed $path
	 * @return bool
	 */
	public function exists($path):bool
	{
		
		return (file_exists($this->path($path))) ? true : false;
		
	}
	
	/**
	* Перемещает,переменовует - файл или папку
	*/	
	/**
	 * move
	 *
	 * @param  mixed $from
	 * @param  mixed $to
	 * @return bool
	 */
	public function move($from, $to):bool
	{
		
		if($this->exists($from) === true)
		{
			copy($this->path($from), $this->path($to));
			
			return true;
		}
		
		return false;
		
	}
	
	/**
	 * remove
	 *
	 * @param  mixed $path
	 * @return void
	 */
	public function remove($path)
	{

		$type = gettype($path);

		if($type == 'string')
		{
			if($this->exists($path) === true)
			{
				unlink($this->path($path));

				return true;
			}
		}

		if($type == 'array')
		{
			if(count($path) > 0)
			{
				foreach($path as $file)
				{
					unlink($this->path($file));

					return true;
				}
			}
		}

		return false;

	}
	
	/**
	* Воврощает имя родительской папки
	*/	
	/**
	 * dirParentName
	 *
	 * @param  mixed $path
	 * @return string
	 */
	public function dirParentName($path):string
	{
		
		return dirname($this->path($path));
		
	}
	
	/**
	* Возврощает информацию о файле
	*/	
	/**
	 * fileInfo
	 *
	 * @param  mixed $path
	 * @param  mixed $options
	 * @return array
	 */
	public function fileInfo($path, $options = null):array
	{
		
		$info = pathinfo($this->path($path, $options)) ?? [];

		if(array_key_exists('extension', $info) === false) $info['extension'] = null;

		return $info;
		
	}
	
	/**
	* Подключает файл
	*/	
	/**
	 * import
	 *
	 * @param  mixed $path
	 * @return void
	 */
	public function import($path)
	{
		
		if($this->exists($path) === true)
		{
			return require $this->path($path);
		}
		
	}
	
	/**
	* Подключение одного файла
	*/	
	/**
	 * oneImport
	 *
	 * @param  mixed $path
	 * @return void
	 */
	public function oneImport($path)
	{
		
		if($this->exists($path) === true)
			return require_once($this->path($path));
		
		return false;
		
	}
	
	/**
	* Читение данных из файла
	*/	
	/**
	 * readFile
	 *
	 * @param  mixed $path
	 * @return void
	 */
	public function readFile($path)
	{
		
		return ($this->exists($path) === true) ? file_get_contents($this->path($path)) : false;
		
	}
	
	/**
	* Читение данных по url
	*/	
	/**
	 * readUrl
	 *
	 * @param  mixed $url
	 * @return void
	 */
	public function readUrl($url)
	{
		
		return file_get_contents($url);
		
	}
	
	/**
	* Возврощает массив данных из файла, по разделителю
	*/	
	/**
	 * dataArray
	 *
	 * @param  mixed $path
	 * @param  mixed $delimiter
	 * @return array
	 */
	public function dataArray($path, $delimiter = null):array
	{
		
		$import = $this->readFile($path);
		
		$delimiter = ($delimiter === null || empty($delimiter)) ? PHP_EOL : $delimiter;
		$expData = explode($delimiter, $import);
		$data = [];
		
		foreach($expData as $v) 
		{
			empty($v) === false ? $data[] = $v : false;
		}
		
		return $data ?? [];
		
	}
	
	/**
	* Установить права для файла или папки
	*/	
	/**
	 * attributes
	 *
	 * @param  mixed $path
	 * @param  mixed $mode
	 * @return void
	 */
	public function permission($path, $mode = 0755)
	{
		
		if($this->exists($path) === true)
		{
			chmod($this->path($path), $mode);
			
			return true;
		}
		
		return false;
		
	}
	
	/**
	* Получить права файла или папки
	*/	
	/**
	 * getAttributes
	 *
	 * @param  mixed $path
	 * @return void
	 */
	public function getPermissions($path)
	{
		
		if($this->exists($path))
			return substr(sprintf('%o', fileperms($this->path($path))), -4);
		return false;
		
	}
	
	/**
	* Изменяет группу
	*/	
	/**
	 * groups
	 *
	 * @param  mixed $path
	 * @param  mixed $group
	 * @return void
	 */
	public function groups($path, $group) 
	{
		
		if($this->exists($path))
			return chgrp($this->path($path), $group);
		
		return false;
		
	}
	
	/**
	* Установить владельца файла или папки
	*/	
	/**
	 * owner
	 *
	 * @param  mixed $path
	 * @param  mixed $username
	 * @return void
	 */
	public function owner($path, $username)
	{
		
		if($this->exists($path) === true)
		{
			chown($this->path($path), $username);
			
			return true;
		}
		
		return false;
		
	}
	
	/**
	* Возврощает дату последнего изминения в файле
	*/	
	/**
	 * lastEditFile
	 *
	 * @param  mixed $path
	 * @return void
	 */
	public function lastEditFile($path)
	{
		
		if($this->exists($path))
			return filemtime($this->path($path));
		return false;
		
	}
	
	/**
	* Воврощает размер файла в байтах
	*/	
	/**
	 * sizeFile
	 *
	 * @param  mixed $path
	 * @return void
	 */
	public function sizeFile($path)
	{
		
		if($this->exists($path))
			return filesize($this->path($path));
		return false;
		
	}
	
	/**
	 * create
	 *
	 * @param  mixed $path
	 * @return void
	 */
	public function create(string $path)
	{

		$path = $this->path($path);

		$file = fopen($path, 'w+');
		fclose($file);

		$this->permission($path);

		return $this;

	}
	
	/**
	 * ignore
	 *
	 * @param  mixed $paths
	 * @return void
	 */
	public function ignore(...$paths)
	{

		$this->ignoresPath = array_map(function($dir) {
			return trim($dir, '/').'/';
		}, $paths);

		return $this;

	}
		
	/**
	 * searchByRegex
	 *
	 * @param  mixed $value
	 * @param  mixed $file
	 * @return void
	 */
	private function searchByRegex($value, $file)
	{
		echo $file.'<br>';
		if(preg_match('/'.$value.'/', $file)) return true;
		else return false;

	}

	/**
	 * search
	 *
	 * @param  mixed $file
	 * @param  mixed $path
	 * @return void
	 */
	public function search(array $file, ?string $path = null)
	{
		$searchedFiles = [];

		$doRootPath = $path;

		if($path === null) $path = Url::rootPath();
		else $path = trim($path, '/').'/';

		$scan = array_diff(scandir($path), ['.', '..']);

		foreach($scan as $dir)
		{
			$nextPath = $path.$dir;
			$doRootPath = \Store::replace([Url::rootPath() => ''], $doRootPath);

			if(in_array($dir.'/', $this->ignoresPath) === false && in_array(trim($doRootPath, '/').'/', $this->ignoresPath) === false) {
				if(is_dir($nextPath)) {
					$this->search($file, $nextPath);
				}
				if(is_file($nextPath)) {
					$nextPath = \Store::replace(['/' => '\\'], $nextPath);
					$explode = explode('\\', $nextPath);
					$explode = explode('/', $explode[array_key_last($explode)]);
					$last = array_key_last($explode);

					$info = $this->fileInfo($explode[$last]);

					foreach($file as $key => $value)
					{
						if(array_key_exists($key, $info)) {
							if($file[$key] === $info[$key]) {
								$this->searched[] = $nextPath;
							}
						} 
					}
				}
			}
		}

		return $this;

	}
	
	/**
	 * execSearch
	 *
	 * @return void
	 */
	public function execSearch()
	{

		return $this->searched;

	}
	
}