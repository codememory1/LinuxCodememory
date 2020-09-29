<?php

namespace System\Support\Session;

use System\Database\DBRedis;
use Random;
use Cookie;

class Session
{

    const KEY_SESSION = 'PHPSESSID:%s:%s';
    
    /**
     * data
     *
     * @var array
     */
    private $data = [];
    
    /**
     * life
     *
     * @var int
     */
    private $life = 86400; // 1 DAY
    
    /**
     * redis
     *
     * @var object
     */
    private $redis;
    
    /**
     * nameSess
     *
     * @var string
     */
    private $nameSess;
    
    /**
     * sessionId
     *
     * @var mixed
     */
    private $sessionId;
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {

        $this->redis = new DBRedis();

    }
    
    /**
     * sessionId
     *
     * @return void
     */
    public function sessionId()
    {

        return Cookie::get('PHPSESSID');

    }
        
    /**
     * setSessionId
     *
     * @param  mixed $key
     * @return void
     */
    public function setSessionId(string $key)
    {

        $this->sessionId = $key;

        return $this;

    }

    /**
     * name
     *
     * @param  mixed $name
     * @return void
     */
    private function name(string $name)
    {

        return sprintf(self::KEY_SESSION, $this->sessionId ?? $this->sessionId(), $name);

    }
        
    /**
     * life
     *
     * @param  mixed $time
     * @return void
     */
    public function life(int $time)
    {

        $this->life = $time;

        return $this;

    }
        
    /**
     * renderData
     *
     * @param  mixed $data
     * @return array
     */
    private function renderData($data)
    {

        return serialize([
            'value' => $data,
            'key'   => Random::randAny(16)
        ]);

    }

    /**
     * create
     *
     * @param  mixed $name
     * @param  mixed $data
     * @return void
     */
    public function create(string $name, $data)
    {

        $this->redis->set($this->name($name), $this->renderData($data), $this->life);

        return $this;

    }
    
    /**
     * get
     *
     * @param  mixed $name
     * @return void
     */
    public function get(string $name)
    {

        if($this->has($name) === true)
        {
            return unserialize($this->redis->get($this->name($name)))['value'];
        }

        return null;

    }
    
    /**
     * getRemove
     *
     * @param  mixed $name
     * @return void
     */
    public function flash(string $name)
    {

        $data = null;

        if($this->has($name) === true)
        {   
            $data = unserialize($this->redis->get($this->name($name)))['value'];
            $this->remove($name);

            return $data;
        }

        return null;

    }
    
    /**
     * key
     *
     * @param  mixed $name
     * @return void
     */
    public function getKey(string $name)
    {

        if($this->has($name) === true)
        {
            return unserialize($this->redis->get($this->name($name)))['key'];
        }

    }
    
    /**
     * append
     *
     * @param  mixed $name
     * @param  mixed $data
     * @return object
     */
    public function append(string $name, $data):object
    {

        if($this->has($name) === true)
        {
            $this->redis->append($this->name($name), $data);
        }

        return $this;

    }
    
    /**
     * remove
     *
     * @param  mixed $name
     * @return object
     */
    public function remove(string $name):object
    {

        if($this->has($name) === true)
        {
            $this->redis->del($this->name($name));
        }

        return $this;

    }
    
    /**
     * has
     *
     * @param  mixed $name
     * @return bool
     */
    public function has(string $name):bool
    {

        return $this->redis->exists($this->name($name)) === 1 ? true : false;

    }

}