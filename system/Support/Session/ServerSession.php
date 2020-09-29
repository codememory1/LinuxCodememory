<?php

namespace System\Support\Session;

use System\Support\SupportInterface\CommonDataInterface;
use System\Support\Exceptions\NotFoundSessionException;
use Random;
use Date;
use Store;
use File;

/**
 * Class Session
 * @package System\Support
 */
class ServerSession implements CommonDataInterface
{

    /**
     * @var int
     */
    private $time = 1; // 1 day

    /**
     * @var string
     */
    private $name;

    /**
     * @var string|array
     */
    private $data;
    
    /**
     * @var int
     */
    private $key;

    /**
     * @param $key
     *
     * @return bool
     */
    public function has($key)
    {
        
        return (isset($_SESSION[$key])) ? true : false;
        
    }

    /**
     * @param $save_path
     * @param $name
     *
     * @return bool
     */
    public function install($save_path, $name)
    {
        return \SessionHandler::open($save_path, $name);
    }

    /**
     * @param $session_id
     * @param $session_data
     *
     * @return bool
     */
    public function write($session_id, $session_data)
    {
        return \SessionHandler::write($session_id, $session_data);
    }

    /**
     * @param   null $prefix
     *
     * @return string
     */
    public function idSession($prefix = null)
    {
        return session_create_id();
    }

    /**
     * @param $key
     * @param $value
     * @param   null $time
     *
     * @return $this|mixed
     */
    public function create($key, $value, $time = null)
    {

        /** @var TYPE_NAME $time */
        $time = (is_null($time)) ? $this->time * 24 * 60 * 60 : $time * 24 * 60 * 60;
        
        //session_cache_expire($time);
        
        $randKey = Random::randInt(8);
            
        $_SESSION[$key] = [
            'key'   => $randKey,
            'value' => $value
        ];

        $this->name = $key;
        $this->data = $value;
        
        $this->key = $_SESSION[$key]['key'];
        
        return $this;
        
    }

    /**
     * @return bool
     */
    public function file()
    {
        if(!Store::exists('storage/cache/Sessions/session_'.$this->key.'.vdf'))
        {
            Store::overwrite('storage/cache/Sessions/session_'.$this->key, serialize($this->data), '.vdf');
        }
        return false;
    }

    /**
     * @param $key
     * @param $value
     *
     * @return bool
     */
    public function prepend($key, $value)
    {
        
        if($this->has($key) === true)
        {
            if(is_array($value))
            {
                array_push($_SESSION[$key]['value'], $value);
            }else{
                $_SESSION[$key]['value'] .= $value;
            }
            
        }
        return false;
    }

    /**
     * @param $key
     *
     * @return bool|mixed
     */
    public function get($key)
    {
        
        if($this->has($key) === true)
        {
            return $_SESSION[$key]['value'];
        }
		
        return false;
    }

    /**
     * @param $key
     *
     * @return mixed|void
     */
    public function delete($key)
    {
        
        if($this->has($key) === true)
        {
            unset($_SESSION[$key]);
        }
        
        Store::remove('storage/cache/Sessions/')->file('session_'.$this->key, '.vdf');
        
    }

    /**
     * @param $key
     *
     * @return bool|mixed
     * @throws NotFoundSessionException
     */
	public function flash($key)
	{
		
		$session = null;
		
		if($this->has($key))
		{
			$session = $this->get($key);
			
			$this->delete($key);
		}
		
		return $session;
		
	}
	
	/**
     * @return bool|mixed
     */
	public function all()
	{
		
		return $_SESSION;
		
    }
        
    /**
     * allEmptRemove
     *
     * @return void
     */
    public function allEmptRemove()
    {

        $scan = Store::scan('storage/session/');

        $all = array_map(function($v) {
            return 'storage/session/'.$v;
        }, $scan);

        if(count($all) > 0)
        {
            foreach($all as $file)
            {
                
                Store::getApi('storage/session/'.$file) == '' ? File::remove($all) : true;
            }
        }

    }
    
}