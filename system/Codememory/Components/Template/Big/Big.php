<?php

namespace System\Codememory\Components\Template\Big;

use System\Codememory\Components\Template\Big\Interfaces\ConfigurationInterface;
use System\Codememory\Components\Template\Big\Components;
use System\Codememory\Components\Template\Big\HandlerComponents;
use Store;
use File;

/**
 * Big
 * @package System\Codememory\Components\Template\Big
 */
class Big
{
    
    /**
     * conf
     *
     * @var mixed
     */
    private $conf;
        
    /**
     * components
     *
     * @var mixed
     */
    private $components;
    
    /**
     * data
     *
     * @var array
     */
    private $data = [];
    
    /**
     * pathView
     *
     * @var string
     */
    private $pathView;

    /**
     * __construct
     *
     * @param  ConfigurationInterface $configuration
     * @return void
     */
    public function __construct(ConfigurationInterface $configuration)
    {

        $this->conf = $configuration;
        $this->components = new Components();

    }
        
    /**
     * path
     *
     * @param  mixed $path
     * @return string
     */
    private function path(string $path):string
    {

        return Store::replace(['.' => '/'], $path);

    }
    
    /**
     * replaces
     *
     * @param  mixed $view
     * @return void
     */
    private function replaces(string $view)
    {

        $data = Store::getApi($this->pathView.$this->path($view).ConfigurationInterface::EXPANSION);
        $handler = new HandlerComponents();

        foreach($this->components->all() as $k => $regex)
        {
            $method = 'component'.one_up_line($k);

            $search = preg_match_all($regex, $data, $matches);

            if($search > 0) {
                $data = $handler->$method($matches, $regex, $data);
            }
        }

        $hashFileView = md5($this->path($view));

        Store::overwrite($this->conf->cache.$view, $data, '.php');

        ob_start();

        extract($this->data);
        require $this->conf->cache.$view.'.php';

        ob_end_flush();

    }
    
    /**
     * views
     *
     * @param  mixed $pathView
     * @return void
     */
    public function views(string $pathView)
    {

        $this->pathView = trim($pathView, '/').'/';

        return $this;

    }
    
    /**
     * make
     *
     * @param  mixed $big
     * @return void
     */
    public function make(string $big)
    {

        $this->replaces($big);

        if($this->conf->autoDeleteTemplate === true)
        {
            $this->autoDeleteTemplate();
        }

        return $this;

    }
    
    /**
     * data
     *
     * @param  mixed $data
     * @return void
     */
    public function data(array $data = [])
    {

        $this->data = $data;

        return $this;

    }
    
    /**
     * autoDeleteTemplate
     *
     * @return void
     */
    private function autoDeleteTemplate()
    {

        $cache = Store::scan($this->conf->cache);
        $views = Store::scan($this->pathView);

        $map = function($value)
        {
            return Store::replace(['.php' => '.big'], $value);
        };

        $cache = array_map($map, $cache);

        foreach($cache as $viewCache)
        {
            if(File::exists($this->pathView.$viewCache) === false)
            {
                File::remove(Store::replace(['.big' => '.php'], $this->conf->cache.Store::replace(['.big' => '.php'], $viewCache)));
            }
        }

    }

}