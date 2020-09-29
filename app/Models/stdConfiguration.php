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

        $this->propertys[$property] = is_array($value) ? json_decode(json_encode($value), false) : $value;

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
    

}