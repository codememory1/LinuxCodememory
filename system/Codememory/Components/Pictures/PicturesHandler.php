<?php

namespace System\Codememory\Components\Pictures;

use System\Codememory\Components\Pictures\Factory as PicturesFactory;
use System\Codememory\Components\Pictures\Interfaces\ImageFormats;
use System\Codememory\Components\Pictures\Exceptions\InvalidUnitImageException as UnitError;
use System\Codememory\Components\Pictures\ColorManager as Color;
use Url;

/**
 * PicturesHandler
 */
class PicturesHandler implements ImageFormats
{

    const UNITS = ['mm', 'cm', 'pt', 'pc', 'em', 'px'];
    
    /**
     * calculate_unit_in_px
     *
     * @var array
     */
    public $calculate_unit_in_px = [
        'mm' => 3.7,
        'cm' => 37.7,
        'pt' => 1.3,
        'pc' => 63.7,
        'em' => 12,
        'px' => 1
    ];
    
    /**
     * width
     *
     * @var int
     */
    public $width = 150;
    
    /**
     * height
     *
     * @var int
     */
    public $height = 150;
    
    /**
     * unit
     *
     * @var string
     */
    public $unit = 'px';
    
    /**
     * positionStyle
     *
     * @var array
     */
    public $positionStyle = [];
    
    /**
     * positions
     *
     * @var mixed
     */
    public $positions;
    
    /**
     * colorManager
     *
     * @var mixed
     */
    private $colorManager;
    
    /**
     * color
     *
     * @var array
     */
    public $color = [];
    
    /**
     * deg
     *
     * @var int
     */
    public $deg = 0;
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {

        $this->colorManager = new Color();

    }
        
    /**
     * calculateUnit
     *
     * @param  mixed $size
     * @return void
     */
    public function calculateUnit($size)
    {

        if(in_array($this->unit, self::UNITS) === true)
        {
            return $this->calculate_unit_in_px[$this->unit] * $size;
        }

        throw new UnitError(implode(',', self::UNITS));
        
    }
    
    /**
     * path
     *
     * @param  mixed $prefix
     * @return void
     */
    public function path($prefix)
    {

        return Url::join($prefix);

    }
    
    /**
     * width
     *
     * @param  mixed $width
     * @return void
     */
    public function width(int $width)
    {

        $this->width = $this->calculateUnit($width);

        return $this;

    }
    
    /**
     * height
     *
     * @param  mixed $height
     * @return void
     */
    public function height(int $height)
    {

        $this->height = $this->calculateUnit($height);

        return $this;

    }
    
    /**
     * unit
     *
     * @param  mixed $unit
     * @return void
     */
    public function unit(string $unit)
    {

        if(in_array($unit, self::UNITS))
        {
            $this->unit = $unit;

            return $this;
        }

        throw new InvalidUnitImageException($unit);

    }
    
    /**
     * position
     *
     * @param  mixed $as
     * @return void
     */
    public function position(string $as)
    {

        $positionsAll = [
            'top', 'bottom', 'left', 'right', 'top-left', 'top-right', 'bottom-left', 'bottom-right', 'left-center', 'right-center', 'top-center', 'bottom-center', 'center'
        ];
        $positionsAll = array_flip($positionsAll)[$as];

        $positionNum = [
            ['x' => 0, 'y' => 0],
            ['x' => 0, 'y' => $this->getHeight() - 10],
            ['x' => 0, 'y' => 0],
            ['x' => $this->getWidth() - 10, 'y' => 0],
            ['x' => 0, 'y' => 0],
            ['x' => $this->getWidth() - 10, 'y' => 0],
            ['x' => 0, 'y' => $this->getHeight() - 10],
            ['x' => $this->getWidth() - 10, 'y' => $this->getHeight() - 10],
            ['x' => 0, 'y' => ($this->getHeight() - 10) / 2],
            ['x' => $this->getWidth() - 10, 'y' => ($this->getHeight() - 10) / 2],
            ['x' => ($this->getWidth() - 10) / 2, 'y' => 0],
            ['x' => ($this->getWidth() - 10) / 2, 'y' => $this->getHeight() - 10],
            ['x' => ($this->getWidth() - 10) / 2, 'y' => ($this->getHeight() - 10) / 2],
        ];

        $this->positionStyle = $positionNum[$positionsAll];

        return $this;

    }
    
    /**
     * positionX
     *
     * @param  mixed $x
     * @return void
     */
    public function positionX($x)
    {

        $this->positions['x'] = $x;

        return $this;

    }
    
    /**
     * positionY
     *
     * @param  mixed $y
     * @return void
     */
    public function positionY($y)
    {

        $this->positions['y'] = $y;

        return $this;

    }
    
    /**
     * positionCX
     *
     * @param  mixed $cx
     * @return void
     */
    public function positionCX($cx)
    {

        $this->positions['cx'] = $cx;

        return $this;

    }
    
    /**
     * positionCY
     *
     * @param  mixed $cy
     * @return void
     */
    public function positionCY($cy)
    {

        $this->positions['cy'] = $cy;

        return $this;

    }
    
    /**
     * getWidth
     *
     * @return void
     */
    public function getWidth()
    {

        return $this->width = imagesx($this->image);
        
    }
    
    /**
     * getHeight
     *
     * @return void
     */
    public function getHeight()
    {

        return $this->height = imagesy($this->image);
        
    }
    
    /**
     * color
     *
     * @param  mixed $color
     * @param  mixed $opacity
     * @return void
     */
    public function color(string $color, int $opacity = 0)
    {

        $this->colorManager->opacity($opacity);
        $colorArray = $this->colorManager->generateRgbColor($color);
        $this->color = imagecolorallocatealpha($this->image, $colorArray['red'], $colorArray['green'], $colorArray['blue'], $colorArray['opacity']);

        return $this;

    }
    
    /**
     * deg
     *
     * @param  mixed $deg
     * @return void
     */
    public function deg(int $deg)
    {

        $this->deg = $deg;

        return $this;

    }

    /**
     * crop
     *
     * @param  mixed $callback
     * @return void
     */
    public function crop(callable $callback)
    {

        call_user_func_array($callback, [$this]);

        $this->image = imagecrop($this->positions['x'], $this->positions['y'], $this->width, $this->height);

        return $this;

    }
    
    /**
     * arc
     *
     * @param  mixed $callback
     * @return void
     */
    public function arc(callable $callback)
    {

        call_user_func_array($callback, [$this]);

        imagearc($this->image, $this->positions['cx'] ?? 0, $this->positions['cy'] ?? 0, $this->width, $this->height, $this->deg[0], $this->deg[1], $this->color);

    }
    
    /**
     * background
     *
     * @param  mixed $color
     * @param  mixed $opacity
     * @return void
     */
    public function background(string $color, int $opacity = 0)
    {

        $this->color($color, $opacity);

        imagefill($this->image, $this->position['x'], $this->position['y'], $this->color);

        return $this;

    }

    public function elipce()
    {

        

    }
    
    /**
     * insert
     *
     * @param  mixed $insert
     * @param  mixed $callback
     * @return void
     */
    public function insert($insert, callable $callback = null)
    {

        call_user_func_array($callback, [$this]);

        imagecopy($this->image, $insert, $this->positions['x'][0], $this->positions['y'][0], $this->positions['x'][1], $this->positions['y'][1], $this->width, $this->height);

        return $this;

    }
        
    /**
     * widthLine
     *
     * @param  mixed $size
     * @return void
     */
    public function widthLine(int $size)
    {

        imagesetthickness($this->image, $size);

        return $this;

    }

    /**
     * create
     *
     * @param  mixed $callback
     * @return void
     */
    public function create(callable $callback = null)
    {

        call_user_func_array($callback, [$this]);

        $this->image = imagecreatetruecolor($this->width, $this->height);

        return $this;

    }
    
    /**
     * open
     *
     * @param  mixed $path
     * @param  mixed $format
     * @param  mixed $callback
     * @return void
     */
    public function open($path, $format, $callback = null)
    {
        if(is_null($callback) === false)
        {
            call_user_func_array($callback, [$this]);
        }

        $this->image = $format($this->path($path));

        return $this;

    }
    
    /**
     * save
     *
     * @return void
     */
    public function save()
    {

        header('Content-Type: image/png');
        imagepng($this->image);

        imagedestroy($this->image);

    }


}