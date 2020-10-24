<?php

namespace App\Models;

/**
 * stdConfiguration
 */
class stdConfiguration
{
    
    /**
     * propertys
     *
     * @var array
     */
    private $propertys = [];
    
    /**
     * __set
     *
     * @param  mixed $property
     * @param  mixed $value
     * @return mixed
     */
    public function __set($property, $value)
    {

        $this->propertys[$property] = $value;

        return $this;

    }
    
    /**
     * __get
     *
     * @param  mixed $property
     * @return mixed
     */
    public function __get($property)
    {

        return $this->propertys[$property];

    }
    
    /**
     * __isset
     *
     * @param  mixed $property
     * @return void
     */
    public function __isset($property)
    {
        
        if(array_key_exists($property, $this->propertys)) {
            return $this->propertys[$property];
        }

        return null;

    }
    

}