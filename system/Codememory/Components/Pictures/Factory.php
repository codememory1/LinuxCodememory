<?php

namespace System\Codememory\Components\Pictures;

use System\Codememory\Components\Pictures\Interfaces\ImageFormats;
use System\Codememory\Components\Pictures\Exceptions\InvalidUnitImageException as UnitError;
use Url;

/**
 * PicturesHandler
 */
class Factory implements ImageFormats
{
    
    /**
     * std
     *
     * @var mixed
     */
    private $std;
    
    /**
     * __construct
     *
     * @param  mixed $std
     * @return void
     */
    public function __construct($std)
    {

        $this->methods = $std;
        
    }
    
    /**
     * __call
     *
     * @param  mixed $method
     * @param  mixed $params
     * @return void
     */
    private function __call($method, $params)
    {

        return $this->std->$method($params);

    }
    
    /**
     * __get
     *
     * @param  mixed $property
     * @return void
     */
    private function __get($property)
    {

        return $this->std->$property;

    }

    /**
     * createImage
     *
     * @param  mixed $path
     * @return void
     */
    public function createImage()
    {
        
        $this->openImage = imagecreatetruecolor($this->width, $this->height);

        return $this;

    }

}