<?php

namespace System\Inc;

use System\Inc\Exceptions\InvalidArgumentConsinderException;

/**
 * ConstructorCreate
 */
class ConstructorCreate
{
        
    /**
     * path
     *
     * @var mixed
     */
    private $path;
    
    /**
     * system
     *
     * @var array
     */
    private $system = [];
    
    /**
     * paths
     *
     * @var array
     */
    private $paths = [];

    /**
     * __construct
     *
     * @param  mixed $path
     * @return void
     */
    public function __construct(string $path)
    {
        
        $this->path = $path;

    }

    private function handlerConsider($system)
    {
        foreach($system as $key => $value)
        {   
            if(is_array($value) === true) {
                $this->path .= $key;
                $this->paths[] = $this->path;

                $this->handlerConsider($value);
            }

            if(is_string($value) === true) {
                $this->path .= $value;

                $this->paths[] = $this->path;
                
            }   
        }
    }

    public function consider(array $system)
    {

        if(array_key_exists('system', $system) === false) {
            throw new InvalidArgumentConsinderException();
        } else {
            $this->system = $system['system'];
            $this->handlerConsider($system['system']);
        }

        debug($this->paths);

    }
    
}