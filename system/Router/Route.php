<?php

namespace System\Router;

use System\Codememory\AbstractComponent\ControllersObserver\Observer;
use System\Router\Exceptions\NotFoundControllerException;
use System\Router\Exceptions\NotFoundMethodInControllerException;
use File;

/**
 * Class Route
 * @package Router
 */
class Route
{

    /**
     * @var string
     */
	public $patch;

    /**
     * @var callback|string
     */
	private $callback;
	
	/**
     * @var string
     */
	private $method;

    /**
     * @var array
     */
	private $matches = [];

    /**
     * @var array
     */
	private $with = [];

    /**
     * @var array
     */
	public $names = [];
	
	/**
     * @var array
     */
	public $access;

    /**
     * Route constructor.
     *
     * @param $patch
     * @param $callback
     */
	public function __construct($patch, $callback, $method, $access)
	{
		
		$this->patch = $patch;
		$this->callback = $callback;
		$this->method = $method;
		$this->access = substr($access, 0, -1);
	}
	
	private function accessHandle()
	{
		
		if(!empty($this->access))
		{
			$namespace = 'Access\\';
		
			foreach(explode('|', $this->access) as $access)
			{
				$fullName = $access.'Access';
				
				call_user_func_array([$namespace.$fullName, 'accessHandle'], []);
			}
		}
	}
	
    /**
     * Замена параметров
     *
     * @param $url
     *
     * @return bool
     */
	public function match($url)
	{
		
		$patch = preg_replace_callback('#:([\w]+)#', [$this, 'replaceParam'], $this->patch);
		
		$regex = '#^'.$patch.'$#i';
		
		if(!preg_match($regex, $url, $matches))
			return false;
		else 
		{
			array_shift($matches);
		
			$this->matches = $matches;

			$this->accessHandle();

			return true;
		}
		
	}

    /**
     * Callback функция замены параметров
     *
     * @param $match
     *
     * @return string
     */
	private function replaceParam($match)
	{
		
		if(array_key_exists($match[1], $this->with))
		{
			if($this->with[$match[1]] == '*')
			{
				return '([^/]+)';
			}
			
			return '(?:'.$this->with[$match[1]].')';
		}
		
		return '([^/]+)';
		
	}

    /**
     * Regex для параметров
     *
     * @param $param
     * @param $regex
     *
     * @return $this
     */
	public function with($param, $regex)
	{
		
		$this->with[$param] = $regex;
		
		return $this;
		
	}

    /**
     * Имя для маршрута
     *
     * @param $name
     *
     * @return $this
     */
	public function name($name)
	{
		
		$this->names[$name] = $this;
		
		return $this;
		
	}

    /**
     * Проверка существования контроллера
     *
     * @param $namespace
     *
     * @return bool
     */
	private function existController($namespace)
	{

		if(!class_exists($namespace))
			throw new NotFoundControllerException($namespace);
		else
			return true;
		
	}

    /**
     * Проверка существования метода в контроллере
     *
     * @param $namespace
     * @param $method
     *
     * @return bool
     */
	private function existsMethodController($namespace, $method)
	{
		
		list($controller, $method) = explode('@', $this->callback);
		
		if(!method_exists($namespace, $method))
			throw new NotFoundMethodInControllerException($namespace, $method);
		else
			return true;
		
	}
	
    /**
     * Метод, который будет вызван, если будет вызван контроллер
     *
     * @return mixed
     */
	private function controller($services)
	{	
		
		list($controller, $method) = explode('@', $this->callback);
		
		$namespace = 'App\\Controllers\\'.$controller;

		foreach($services->services as $service => $object)
		{
			$this->matches[$service] = $object;
		}

		if($this->existController($namespace) === true)
		{
			if($this->existsMethodController($namespace, $method) === true)
			{
				$observer = new Observer();
				$configObserver = File::import('config/Codememory/controllerObservers.php');
		
				if(count($configObserver) > 0)
				{
					foreach($configObserver as $k => $observe)
					{
						$ob = new $observe();

						$observer->register($ob);

						foreach($ob->getObController()[0] as $k => $obController)
						{
							if($obController instanceof $namespace === true)
							{
								$ob->supplement($obController);
							}
						}
					}
				}

				return call_user_func_array([new $namespace(), $method], $this->matches);
				
			}		
		}
		   
	}

    /**
     * Метод возврощает: callback, или контроллер с методом
     *
     * @return mixed
     */
	public function invoke($services)
	{
		
		return (is_callable($this->callback)) ? 
			$this->call() : 
		$this->controller($services);
		
	}
	
    /**
     * Возврощает callback функцию
     *
     * @return mixed
     */
	public function call()
	{
		
		return call_user_func_array($this->callback, $this->matches);
		
	}
	
}