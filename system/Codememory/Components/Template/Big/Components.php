<?php

namespace System\Codememory\Components\Template\Big;

/**
 * Components
 * @package System\Codememory\Components\Template\Big
 */
class Components
{

    private $components = [
        'startPhp'      => '/\[php(?:\s+)?\((.*)\)/',                    /** - <?php */
        'endPhp'        => '/(?:\s+)?php\]/',                            /** - ?> */
        'echo'          => '/\[\[\s+(.*)\s+\]\]/U',             /** - <?php echo ... ?> */
        'require'       => '/\[\@import\((.*)\)\]/',                     /** - <?php \File::import(...); ?> */
        'requireOnce'   => '/\[\@import\-once\((.*)\)\]/',               /** - <?php \File::oneImport(...); ?> */
        'importTheme'   => '/\[\@theme\((.*)\)\]/',                      /** - <?php echo \View::theme(...); ?> */
        'foreach'       => '/\[\@foreach\s+(.*)\]/',                     /** - <?php foreach(...): ?> */
        'endForeach'    => '/\[\@endForeach\]/',                         /** - <?php endforeach; ?> */
        'for'           => '/\[\@for\s+(.*)\]/',                         /** - <?php for(...): ?> */
        'endFor'        => '/\[\@endFor\]/',                             /** - <?php endfor; ?> */
        'while'         => '/\[\@while\s+(.*)\]/',                       /** - <?php while(...): ?> */
        'endWhile'      => '/\[\@endWhile\]/',                           /** - <?php endwhile(...): ?> */
        'if'            => '/\[\@if\s+(.*)\]/',                          /** - <?php if(...): ?> */
        'elseIf'        => '/\[\@elseIf\s+(.*)\]/',                      /** - <?php elseif(...): ?> */
        'else'          => '/\[\@else\]/',                               /** - <?php else: ?> */
        'endIf'         => '/\[\@endIf\]/',                              /** - <?php endif; ?> */
        'Assets'        => '/\[\@assets\((.*)(?:\s+)?\,(.*)\)\]/',       /** - <?php echo \Assets::execute()->css|js(...); ?> */
        'Build'         => '/\[\@build\((.*)(?:\s+)?\,(.*)\)\]/',        /** - <?php echo \Build::execute()->css|js(...); ?> */
        'use'           => '/\[\@use\(([^\,]+)(?:\,(?:\s+)?(.*))?\)\]/', /** - <?php $namespace = 'NameSpace\Class'; $class = new $namespace(); ?> */
    ];
    
    /**
     * setComponent
     *
     * @param  mixed $nameHandler
     * @param  mixed $regex
     * @return void
     */
    public function setComponent(string $nameHandler, string $regex)
    {

        $this->components[$nameHandler] = $regex;

        return $this;

    }
    
    /**
     * redirectToMethod
     *
     * @param  mixed $name
     * @param  mixed $newFunc
     * @return void
     */
    public function redirectToMethod(string $name, string $newFunc)
    {

        if(array_key_exists($name, $this->components) === true)
        {
            $regex = $this->components[$name];
            unset($this->components[$name]);

            $this->components += [$newFunc => $regex];

            return true;
        }

        return false;

    }
    
    /**
     * all
     *
     * @return void
     */
    public function all():array
    {

        return $this->components;

    }

}