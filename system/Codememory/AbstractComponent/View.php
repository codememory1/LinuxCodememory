<?php

namespace System\Codememory\AbstractComponent;

use System\Codememory\AbstractComponent\ViewInterface;
use Jenssegers\Blade\Blade;
use System\Exceptions\SleshPatchException;
use System\Codememory\Components\Template\Big\Big;
use System\Codememory\Components\Template\Big\Configuration;
use Store;
use Url;
use Response;

/**
 * Class View
 * @package System\Codememory\AbstractComponent
 */
class View implements ViewInterface
{
	
	const PATH_RESOURCES_CACHE = 'storage/cache/Views/';
	const PATH_THEME_CACHE = 'storage/cache/Views/Theme/';
		
	/**
	 * render
	 *
	 * @var mixed
	 */
	private $render;
		
	/**
	 * vars
	 *
	 * @var array
	 */
	private $vars = [];
		
	/**
	 * names
	 *
	 * @var array
	 */
	private $names = [];
		
	/**
	 * contents
	 *
	 * @var mixed
	 */
	private $contents;
		
	/**
	 * view
	 *
	 * @param  mixed $view
	 * @param  mixed $vars
	 * @param  mixed $path
	 * @param  mixed $pathCache
	 * @return void
	 */
	private function view($view, array $vars, $path, $pathCache)
	{
		
		$view = Store::replace(['.' => '/'], $view);

		$blade = new Blade(Url::join($path), Url::join($pathCache));
		
		extract($vars);

		return $this->setContents($blade->make($view, $vars)->render())->getContents();
		
	}
	
	/**
	 * configurationBig
	 *
	 * @param  mixed $cache
	 * @param  mixed $template
	 * @param  mixed $data
	 * @return void
	 */
	private function configurationBig(string $cache, string $listTemplates, string $template, array $data = [])
	{

		$conf = new Configuration();
		$conf->cache($cache)
			->autoDeleteTemplate(false);
		
		$big = new Big($conf);
		$big->data($data)
			->views($listTemplates)
			->make($template);

	}
	
	/**
	 * big
	 *
	 * @param  mixed $path
	 * @param  mixed $data
	 * @return void
	 */
	public function big(string $path, array $data = [])
	{

		return $this->configurationBig('/storage/cache/Big/', 'resources/Views/', $path, $data);

	}
		
	/**
	 * getVars
	 *
	 * @return void
	 */
	public function getVars()
	{
		
		return $this->vars;
		
	}
	    
    /**
     * render
     *
     * @param  mixed $view
     * @param  mixed $vars
     * @return void
     */
    public function render($view, array $vars = [])
	{
		
		$this->view($view, $vars, 'resources/Views', self::PATH_RESOURCES_CACHE);
		$this->vars = $vars;
		
		return $this;
		
	}
		
	/**
	 * theme
	 *
	 * @param  mixed $view
	 * @param  mixed $vars
	 * @return void
	 */
	public function theme($view, array $vars = [], ?string $temaplte = 'big')
	{
		
		if($temaplte === 'big')
		{
			return $this->configurationBig('/storage/cache/Big/', 'resources/Theme', $view, $vars);
		}
		
		return $this->view($view, $vars, 'resources/Theme', self::PATH_THEME_CACHE);
		
	}
		
	/**
	 * updateCache
	 *
	 * @return void
	 */
	public function updateCache()
	{
		
		$theme = glob(Url::join(self::PATH_THEME_CACHE).'*.php');
		$views = glob(Url::join(self::PATH_RESOURCES_CACHE).'*.php');
		
		foreach($theme as $file)
		{
			unlink($file);
		}
		
		foreach($views as $file)
		{
			unlink($file);
		}
		
		return true;
		
	}
		
	/**
	 * setContents
	 *
	 * @param  mixed $contents
	 * @return void
	 */
	public function setContents($contents)
	{
		
		$this->contents = Response::setContent($contents);
		
		return $this;
		
	}
		
	/**
	 * getContents
	 *
	 * @return void
	 */
	public function getContents()
	{
		
		return $this->contents->sendContent();
		
	}
		
	/**
	 * with
	 *
	 * @param  mixed $name
	 * @param  mixed $value
	 * @return void
	 */
	public function with($name, $value = null)
	{
		
		$this->vars[$name] = $value;
		
		return $this;
		
	}
	
	public function setName()
	{
		
		
		
	}
	
	public function name()
	{
		
		
		
	}

    
}


