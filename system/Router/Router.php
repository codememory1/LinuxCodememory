<?php

namespace System\Router;

use System\Router\Route;
use System\Router\Exceptions\ParamsCallbackException;
use System\Router\Exceptions\NotFoundNameRouteException;
use Response;
use Store;
use File;
use Common;
use Server;

require dirname(__DIR__) . "/libs/functions.php";

class Router
{

    /**
     * @var array
     */
	private static $routes = [];

    /**
     * @var string
     */
	private static $url;

    /**
     * @var array
     */
	private static $names = [];
	
	/**
     * @var string
     */
	private static $group;
	
	/**
     * @var array
     */
	private static $access;

    /**
     * Router constructor.
     *
     * @param $url
     */
	public function __construct()
	{

		$scanRoutes = Store::scan('app/routes');
		
        foreach($scanRoutes as $routes)
        {
            if(strpos($routes, '-routes.php'))
            {
                list($file, $exc) = explode('.php', $routes);
                
				File::oneImport('app/routes/'.$file.'.php');

            }
        }
		
	}

    /**
     * Метод GET
     *
     * @param $patch
     * @param $callback
     *
     * @return \Router\Route
     */
	public static function get($patch, $callback)
	{
		
		return static::add($patch, $callback, 'GET');
		
	}

    /**
     * Метод POST
     *
     * @param $patch
     * @param $callback
     *
     * @return \Router\Route
     */
	public static function post($patch, $callback)
	{
		
		return static::add($patch, $callback, 'POST');
		
	}

    /**
     * Метод POST или GET
     *
     * @param $patch
     * @param $callback
     *
     * @return \Router\Route
     */
	public static function any($patch, $callback)
	{
		
		return static::add($patch, $callback, 'POST|GET');
		
	}
	
	/**
     * Запрос через AJAX
     *
     * @param $patch
     * @param $callback
     *
     * @return \Router\Route
     */
	public static function ajax($patch, $callback)
	{
		
		return static::add($patch, $callback, 'AJAX');
		
	}

    /**
     * Добавление нового маршрута
     *
     * @param $patch
     * @param $callback
     * @param $method
     *
     * @return \Router\Route
     */
	private static function add($patch, $callback, $methods)
	{
		
		$group = static::$group;
		
		$patch = '/'.trim($patch, '/');
		
		$route = new Route($group.$patch, $callback, $methods, static::$access);
		
		$methods = explode('|', $methods);
		
		foreach($methods as $method) 
		{
			static::$routes[$method][] = $route;
		}
		
		return $route;
		
	}
	
	/**
     * Создание группы маршрутов
     *
     * @param string $group
     * @param callback $callback
     *
     */
	public static function group($group, $callback)
	{
		
		$groups = static::$group;
		
		static::$group .= '/'.trim($group, '/');
		
		if(is_callable($callback)) 
			call_user_func($callback);
		else
			throw new ParamsCallbackException('Метод [Group] должен в качестве 2-го параметра, принимать callback функцию.');
		
		static::$group = $groups;
		
	}
	
	public static function access($access, $callback)
	{
		
		$accesses = static::$access;
		
		static::$access .= trim($access, '|').'|';
		
		if(is_callable($callback))
			call_user_func($callback);
		else
			throw new ParamsCallbackException('Метод [Access] должен в качестве 2-го параметра, принимать callback функцию.');
		
		static::$access = $accesses;
		
	}
	
    /**
     * Проверка на метод запроса
     *
     * @return bool
     */
	private function methodCheck()
	{
		
		$method = Common::getMethod();
		
		$method = (empty($method)) ? 'GET' : $method;

		if(array_key_exists($method, static::$routes))
			return true;
		else
			Response::setResponseCode(405)
				->getContentResponseCode('Method Not Allowed');
		
	}

    /**
     * Проходим циклом по всем маршрутам
     *
     * @return mixed
     */
	private function routesCycle($services)
	{
		
		$url = '/'.trim(Common::getUrl(), '/');
		$method = Common::getMethod();
		
		$matched = false;
		
		if(count(static::$routes) !== 0)
		{
			foreach(static::$routes[$method] as $key => $route)
			{
				if($route->match($url))
					return $route->invoke($services);

			}
			Response::setResponseCode(404)
				->getContentResponseCode('Not Found');
		}
		
		
		
	}

    /**
     * Записать в массив все имена маршрутов
     */
	public function names()
	{
		
		foreach(static::$routes as $method => $route)
		{
			foreach($route as $objectRoute)
			{
				if(!array_keys($objectRoute->names))
					unset($objectRoute->names);
				else
					static::$names[array_keys($objectRoute->names)[0]] = $objectRoute;
			}
		}
		
	}

    /**
     * Проверка имени маршрута и заменя параметров
     *
     * @param $name
     * @param   array $params
     *
     * @return string|string[]
     */
	private function getRoutePatch($name, array $params = [])
	{
		
		if(array_key_exists($name, static::$names))
		{
			
			$patch = static::$names[$name]->patch;
			
			foreach($params as $p => $v)
			{
				$patch = str_replace(':'.$p, $v, $patch);
			}
			
			return $patch;
			
		}
		
		return false;
		
	}

    /**
     * Получить url маршрута и заменить параметры в url, если они есть
     *
     * @param $name
     * @param   array $params
     *
     * @return string|string[]
     */
	public function route($name, array $params = [])
	{
		return static::getRoutePatch($name, $params);
	}
	
	/**
     * Получить все маршруты
     *
     * @return array
     */
	public function all():array
	{
		
		return static::$routes;
		
	}
	
    /**
     * Запуск роутера
     */
	public function routeStart($services)
	{

		static::names();
		
		(static::methodCheck() === true) ? 
			static::routesCycle($services) : 
		false;

	}
	
}