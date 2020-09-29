<?php

namespace System\Http\Header;

use System\Router\Router;
use System\Http\Header\RedirectInterface;

/**
 * Class Redirect
 * @package System\Http\Redirect
 */
class Redirect implements RedirectInterface
{

    /**
     * @var string
     */
    private $uri;

    /**
     * @var int
     */
    private $codeRedirect = 301;

    /**
     * @return $this
     */
    public function redirect($replace = true)
    {

        header('Location: '.$this->uri, $replace, $this->codeRedirect);

        return $this;

    }

    /**
     * @return $this
     */
    public function back()
    {

        $this->uri = $_SERVER['HTTP_REFERER'];

        return $this;

    }
    
    public function getBack()
    {
        
        $this->uri = $_SERVER['HTTP_REFERER'];
        
        return $this->uri;
        
    }

    /**
     * @return array
     */
    private function listRoutes()
    {

        return (array) Router::all();

    }

    /**
     * @param $name
     * @param   null $code
     *
     * @return $this
     * @throws \ErrorException
     */
    public function route($name, $params = [], $code = null)
    {

		$this->uri = route($name, $params);
        $this->codeRedirect = $code;

        return $this;
    }
    
    /**
     * @param $uri
     *
     * @return $this
     */
    public function his($uri)
    {
        $this->uri = $uri;
        
        return $this;
        
    }
    
    public function routeUri($name)
    {
        foreach ($this->listRoutes()[$name] as $routes)
        {
            return (empty($routes['Pattern'])) ? '/' : '/'.$routes['Pattern'];
        }
    }

}