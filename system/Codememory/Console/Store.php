<?php

namespace System\Codememory\Console;

use Date;
use Common;
use Url;
use File;

/**
 * Class Store
 * @package System\Codememory\Console
 */
class Store
{
    
    /**
     * @var string
     */
    private $patch;
    
    /**
     * @var string
     */
    private $file;
    
    /**
     * sizeFIle
     *
     * @var int
     */
    private $sizeFIle = 0;
    
    /**
     * openedEditJsonFile
     *
     * @var mixed
     */
    private $openedEditJsonFile;
    
    /**
     * @param $patch
     * @param $data
     * @param   string $expansion
     */
    public function prepend($patch, $data, $expansion = '.php')
    {
        file_put_contents(Url::rootPath().$patch.$expansion, $data, FILE_APPEND | LOCK_EX );
    }
    
    /**
     * @param $patch
     * @param $data
     * @param   string $expansion
     */
    public function overwrite($patch, $data, $expansion = '.php')
    {
        file_put_contents(Url::rootPath().$patch.$expansion, $data);
    }
        
    /**
     * update
     *
     * @param  mixed $path
     * @param  mixed $data
     * @return void
     */
    public function update(string $path, $data, string $prefix = null)
    {

        $prefix = $prefix === null ? Url::rootPath() : $prefix;

        file_put_contents($prefix.$path, $data);

    }
    
    /**
     * @param $patch
     *
     * @return mixed
     */
    public function remove($patch)
    {
        
        $this->patch = rtrim($patch, '/').'/';
        return $this;
    }
    
    /**
     * @param $file
     * @param   string $expansion
     */
    public function file($file, $expansion = '.php')
    {
        if($this->exists($this->patch.$file.$expansion) === true)
        {
            unlink(Url::rootPath().$this->patch.$file.$expansion);
        }
    }
    
    /**
     * @param $dir
     */
    public function dir($dir)
    {
        if($this->isDir($this->patch.$dir) === true)
        {
            $scan = $this->scan($this->patch.$dir);
            
            if(count($scan) > 0)
            {
                foreach($scan as $dirFile)
                {
                    unlink(Url::rootPath().$this->patch.$dir.'/'.$dirFile);
                    rmdir(Url::rootPath().$this->patch.$dir);
                }
            }
            else {
                rmdir(Url::rootPath().$this->patch.$dir);
            }
            
        }
    }
        
    /**
     * createDir
     *
     * @param  mixed $dir
     * @return void
     */
    public function createDir($dir, string $prefix = null)
    {
        $prefix = $prefix === null ? Url::rootPath() : $prefix;

        if($this->isDir($dir, $prefix) === false)
        {
            mkdir($prefix.$dir);
        }
    }
    
    /**
     * @param  string  $path
     * @param  string  $target
     * @return bool
     */
    public function copy($path, $target)
    {
        return copy(Url::rootPath().$path, Url::rootPath().$target);
    }
        
    /**
     * copyDir
     *
     * @param  mixed $path
     * @param  mixed $target
     * @return void
     */
    public function copyDir($path, $target)
    {
        
        $patch = Url::rootPath().$path;
        $target = Url::rootPath().$target;

        mkdir($target, 0755);
        
        $dir = opendir($patch); 
        
        while($file = readdir($dir)) 
        {
            if(is_file($patch.'/'.$file))
            {
                $cont = file_get_contents($patch.'/'.$file);
                file_put_contents($target."/".$file, $cont);
            }
        }
        
    }
    
    /**
     * @param  string  $path
     * @param  string  $target
     * @return bool
     */
    public function move($path, $target)
    {
        rename(Url::rootPath().$path, Url::rootPath().$target);
    }
    
    /**
     * @param  string  $path
     * @param  string  $data
     * @return int
     */
    public function append($path, $data)
    {
        return file_put_contents(Url::rootPath().$path, $data, FILE_APPEND);
    }
    
    /**
     * @param  string  $path
     * @param  string  $contents
     * @param  bool  $lock
     * @return int
     */
    public function put($path, $contents, $lock = false)
    {
        return file_put_contents(Url::rootPath().$path, $contents, $lock ? LOCK_EX : 0);
    }
    
    /**
     * @param  string  $path
     * @return string
     */
    public function hash($path)
    {
        return md5_file(Url::rootPath().$path);
    }
    
    /**
     * @param  string  $path
     * @return string
     */
    public function basename($path)
    {
        return pathinfo(Url::rootPath().$path, PATHINFO_BASENAME);
    }
    
    /**
     * @param  string  $path
     * @return string
     */
    public function type($path)
    {
        return filetype(Url::rootPath().$path);
    }
    
    /**
     * @param  string  $path
     * @return int
     */
    public function size($path)
    {
        return filesize(Url::rootPath().$path);
    }
    
    /**
     * @param  string  $path
     * @return bool
     */
    public function isDir($path, ?string $prefix = null)
    {
        $prefix = $prefix === null ? Url::rootPath() : $prefix;

        return (is_dir($prefix.$path)) ? true : false;
    }
    
    /**
     * @param  string  $path
     * @return bool
     */
    public function isFile($path, ?string $prefix = null)
    {

        $prefix = $prefix === null ? Url::rootPath() : $prefix;

        return (is_file($prefix.$path)) ? true : false;
    }
    
    /**
     * @param  string  $path
     * @return bool
     */
    public function exists($path)
    {
        return (file_exists(Url::rootPath().$path)) ? true : false;
    }
    
    /**
     * @param  string  $path
     * @param  string  $format
     *
     * @return bool
     */
    public function lastAccess($path, $format)
    {
        return Date::unixDate(fileatime(Url::rootPath().$path))->format($format);
    }
    
    /**
     * @param  string  $path
     *
     * @return mixed|array
     */
    public function rights($path)
    {
        return fileperms(Url::rootPath().$path);
    }
    
    /**
     * @param  string  $path
     *
     * @return array
     */
    public function arrayDataFile($path)
    {
        return file(Url::rootPath().$patch, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }
    
    /**
     * @param  string  $path
     *
     * @return mixed|array
     */
    public function getApi($path)
    {
        return ($this->exists($path) === true) ? file_get_contents(Url::rootPath().$path) : false;
    }
    
    /**
     * @param  string  $path
     *
     * @return mixed|array
     */
    public function scan($path)
    {
		
        $status = ($this->exists($path) === true) ? true : false;
        if($status === true)
        {
			
            $scan = scandir(Url::rootPath().$path);
            array_shift($scan);
            array_shift($scan);
            
            return $scan;
            
        }
    }
        
    /**
     * completeRemove
     *
     * @param  mixed $dir
     * @return void
     */
    public function completeRemove($dir) 
    {

        $dir = rtrim($dir, '/').'/';
        $attached = $this->scan($dir);

        if(is_array($attached) && count($attached) > 0)
        {
            foreach($attached as $att)
            {
                $path = $dir.'/'.$att;
    
                if(is_dir(Url::join($path)))
                {
                    $this->completeRemove($path);
                }
                else {
                    unlink(Url::join($path));
                }
            }
        }

        rmdir(Url::join($dir));
        
    }
    
    /**
     * completeSize
     *
     * @param  mixed $dir
     * @return void
     */
    public function completeSize(string $dir)
    {

        $dir = rtrim($dir, '/').'/';
        $attached = $this->scan($dir);

        if(is_array($attached) && count($attached) > 0)
        {
            foreach($attached as $att)
            {
                $path = $dir.$att;
    
                if(is_dir(Url::join($path)))
                {
                    $this->completeSize($path);
                }
                else {
                    $this->sizeFile += $this->size($path);
                }
            }
        }

        return $this->sizeFile;

    }
    
    /**
     * completeSizeArray
     *
     * @param  mixed $paths
     * @param  mixed $as
     * @return void
     */
    public function completeSizeArray(array $paths, string $as = 'int')
    {

        $sizes = [
            'basic_size' => 0
        ];

        foreach($paths as $path) 
        {
            $sizes[] = [
                'path' => $path,
                'size' => $this->completeSize($path)
            ];
            $sizes['basic_size'] += $this->completeSize($path);
        }

        return $as === 'int' ? $sizes['basic_size'] : $sizes;

    }
    
    /**
     * completeCopy
     *
     * @param  mixed $copy
     * @param  mixed $toCopy
     * @return void
     */
    public function completeCopy(string $copy, string $toCopy)
    {

        $attached = $this->scan($copy);

        if(count($attached) > 0) {
            foreach($attached as $att)
            {
                $path = $copy.'/'.$att;
                $pathTo = $toCopy.'/'.$att;
    
                if(is_dir(Url::join($path))) {
                    $this->createDir($pathTo);
                    $this->completeCopy($path, $pathTo);
                }
                else {
                    $this->copy($path, $pathTo);
                }
            }
        }

    }
        
    /**
     * replace
     *
     * @param  mixed $searchs
     * @param  mixed $where
     * @return void
     */
    public function replace(array $searchs = [], $where)
    {
		
		$searchArr = array_keys($searchs);
		$replace = array_values($searchs);
		
		return str_replace($searchArr, $replace, $where);

    }
		
	/**
	 * upload
	 *
	 * @param  mixed $from
	 * @param  mixed $to
	 * @return void
	 */
	public function upload($from, $to)
	{
		
		move_uploaded_file($from, Url::rootPath().$to);
		
	}
		
	/**
	 * xmlArray
	 *
	 * @param  mixed $path
	 * @return void
	 */
	public function xmlArray($path)
	{
		
		return simplexml_load_file(Url::rootPath().$path);
		
    }
        
    /**
     * editJsonFile
     *
     * @param  mixed $path
     * @return void
     */
    public function editJsonFile(string $path)
    {

        if($this->exists($path) === true) {
            $this->path = $path;
            
            $this->openedEditJsonFile = $this->getApi($path);
        }

        return $this;
        
    }
    
    /**
     * editJson
     *
     * @param  mixed $key
     * @param  mixed $value
     * @return void
     */
    public function editJsonData(callable $callback) 
    {
        
        $toArray = \Response::jsonToArray($this->openedEditJsonFile);
        $data = call_user_func_array($callback, [$toArray]);
        
        $this->update($this->path, \Response::arrayToJson($data));

    }

    /**
     * createFilesystem
     *
     * @param  mixed $path
     * @param  mixed $systems
     * @return void
     */
    public function createFilesystem($path, array $systems)
    {

        foreach($systems as $k => $files)
        {
            if(is_array($files)) {
                $path .= $k.'/';
                $this->createFilesystem($path, $files);
            } else {
                $pathSystem = preg_replace('/(\?\-d|\?\-f)/', '', $files);
                $path = preg_replace('/(\?\-d|\?\-f)/', '', $path);
                
                echo $path.$pathSystem.'<br>';
                
            }
        }

    }
		
	/**
	 * compress
	 *
	 * @param  mixed $string
	 * @param  mixed $length
	 * @return void
	 */
	public function compress($string, int $length = 9)
	{
		
		return gzdeflate($string, $length);
		
	}
		
	/**
	 * uncompress
	 *
	 * @param  mixed $string
	 * @param  mixed $length
	 * @return void
	 */
	public function uncompress($string, int $length = 0)
	{

        return gzinflate($string, $length);
		
	}
    
}