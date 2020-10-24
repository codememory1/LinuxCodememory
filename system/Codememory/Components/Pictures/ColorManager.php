<?php

namespace System\Codememory\Components\Pictures;

use Store;

/**
 * ColorManager
 */
class ColorManager
{
    
    /**
     * opacity
     *
     * @var int
     */
    private $opacity = 0;
    
    /**
     * colorRgb
     *
     * @var array
     */
    private $colorRgb = [];
    
    /**
     * opacity
     *
     * @param  mixed $opacity
     * @return void
     */
    public function opacity(int $opacity)
    {

        $this->opacity = $opacity;
        $this->colorRgb['opacity'] = $this->opacity * 127;

        return $this;

    }
    
    /**
     * hexRgba
     *
     * @param  mixed $hex
     * @return void
     */
    private function hexRgba($hex)
    {

        if(strpos($hex, ',') !== false)
        {
            $this->cropRgb($hex);
        }
        else
        {
            $hex      = Store::replace(['#' => ''], $hex);
            $length   = strlen($hex);
    
            $rgb['red'] = hexdec($length == 6 ? 
                substr($hex, 0, 2) : 
                ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
    
            $rgb['green'] = hexdec($length == 6 ? 
                substr($hex, 2, 2) : 
                ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
    
            $rgb['blue'] = hexdec($length == 6 ? 
                substr($hex, 4, 2) : 
                ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));

            $rgb['opacity'] = $this->opacity;
    
            $this->colorRgb = $rgb;
        }

        return $this;

    }
    
    /**
     * cropRgb
     *
     * @param  mixed $color
     * @return void
     */
    private function cropRgb(string $color)
    {

        list($red, $green, $blue) = explode(',', $color);

        $this->colorRgb['red'] = $red;
        $this->colorRgb['green'] = $green;
        $this->colorRgb['blue'] = $blue;
        $this->colorRgb['opacity'] = $this->opacity;

    }
    
    /**
     * generateRgbColor
     *
     * @param  mixed $color
     * @return array
     */
    public function generateRgbColor(string $color):array
    {

        $this->hexRgba($color);

        return $this->colorRgb;

    }

}