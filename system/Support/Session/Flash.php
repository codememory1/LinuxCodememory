<?php

namespace System\Support\Session;

use System\Support\Session\FlashInterface;
use System\Support\Session\Exceptions\InvalidNameFlashException;
use System\Support\Session\Exceptions\InvalidTypeFlashException;
use Session;

/**
 * Flash
 */
class Flash implements FlashInterface
{

    const NAME_FLASH_MESSAGE = 'Flash-Message';

    /**
     * @var array
     */
    public $messages = [];

    /**
     * @var string
     */
    private $nameFlash = null;
    
    /**
     * add
     *
     * @param  mixed $type
     * @param  mixed $message
     * @return void
     */
    public function add($type, $message)
    {

        if($this->name === null)
        {
            throw new InvalidNameFlashException();
        }
        else
        {
            if(is_array($type) === false)
                $this->messages[$this->name]['type'][$type] = count($this->messages[$this->name]['type'] ?? []);
            else
                $this->messages[$this->name]['type'] = array_flip($type);
                
            is_array($message) === false ? $this->messages[$this->name]['messages'][] = $message : $this->messages[$this->name]['messages'] = $message;

            Session::create(self::NAME_FLASH_MESSAGE, $this->messages);
        }

        return $this;

    }
    
    /**
     * name
     *
     * @param  mixed $name
     * @return void
     */
    public function name(string $name)
    {

        $this->name = $name;

        return $this;

    }
        
    /**
     * get
     *
     * @param  mixed $name
     * @param  mixed $types
     * @return array
     */
    public function get(string $name, ...$types):array
    {
        
        $data = [];

        $this->messages = Session::get(self::NAME_FLASH_MESSAGE) ?: [];

        if(array_key_exists($name, $this->messages) === true)
        {
            if(count($types) > 0)
            {
                $data = $this->getWithType($name, $types);

                return $data;
            }
            else
            {
                $data = $this->getAllTypes($name);

                return $data;
            }
   
        } 

        return [];
        
    }
        
    /**
     * getWithType
     *
     * @param  mixed $name
     * @param  mixed $types
     * @return void
     */
    private function getWithType(string $name, array $types)
    {

        $data = [];

        foreach($types as $type)
        {
            if(array_key_exists($type, $this->messages[$name]['type']) === true)
            {
                $data[$type] = Session::get(self::NAME_FLASH_MESSAGE)[$name]['messages'][$this->messages[$name]['type'][$type]];
            }
        }

        Session::remove(self::NAME_FLASH_MESSAGE);
        
        return $data;

    }

    /**
     * getAllTypes
     *
     * @param  mixed $name
     * @return void
     */
    private function getAllTypes(string $name)
    {

        $data = [];

        foreach($this->messages[$name]['type'] as $type => $typeMessage)
        {
            $data[$type] = Session::get(self::NAME_FLASH_MESSAGE)[$name]['messages'][$this->messages[$name]['type'][$type]];
        }

        Session::remove(self::NAME_FLASH_MESSAGE);
        
        return $data;

    }
    
    /**
     * has
     *
     * @param  mixed $name
     * @return bool
     */
    public function has(string $name):bool
    {

        $this->messages = Session::get(self::NAME_FLASH_MESSAGE) ?: [];

        return array_key_exists($name, $this->messages) === true ? true : false;

    }

}