<?php

namespace System\Http;

use System\Http\Exception\ServerException;

/**
 * Class Server
 * @package System\Http
 */
class Server
{

    /**
     * isset param server
     *
     * @param $key
     *
     * @return bool
     * @throws ServerException
     */
	public function has($key)
	{
		
		if(isset($_SERVER[$key])) {
			return true;
		}
		
	}

    /**
     * get server param
     *
     * @param $key
     *
     * @return mixed|null
     * @throws ServerException
     */
	public function get($key)
	{
		
		 return ($this->has($key)) ? $_SERVER[$key] : null;
		
	}

    /**
     * Add new server param
     *
     * @param $key
     * @param $value
     *
     * @throws ServerException
     */
	public function set($key, $value)
	{
		
		if($this->has($key) === true)
		{
			throw new ServerException("key: <b>${key}</b> already exists.");
		}
		
		$_SERVER[$key] = $value;
		
	}
	
	/**
     * Return all 
	 *
     * @return array
     */
	public function all()
	{
		
		return $_SERVER;
		
	}
	
}