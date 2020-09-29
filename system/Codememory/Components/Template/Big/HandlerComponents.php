<?php

namespace System\Codememory\Components\Template\Big;

/**
 * HandlerComponents
 * @package System\Codememory\Components\Template\Big
 */
class HandlerComponents
{
    
    /**
     * componentStartPhp
     *
     * @param  mixed $matches
     * @param  mixed $regex
     * @param  mixed $data
     * @return void
     */
    public function componentStartPhp(array $matches, $regex, $data)
    {

        
        return preg_replace($regex, "<?php $1;", $data);

    }
    
    /**
     * componentEndPhp
     *
     * @param  mixed $matches
     * @param  mixed $regex
     * @param  mixed $data
     * @return void
     */
    public function componentEndPhp(array $matches, $regex, $data)
    {

        return preg_replace($regex, "?>", $data);

    }
    
    /**
     * componentEcho
     *
     * @param  mixed $matches
     * @param  mixed $regex
     * @param  mixed $data
     * @return void
     */
    public function componentEcho(array $matches, $regex, $data)
    {

        return preg_replace($regex, "<?php echo $1; ?>", $data);

    }
    
    /**
     * componentRequire
     *
     * @param  mixed $matches
     * @param  mixed $regex
     * @param  mixed $data
     * @return void
     */
    public function componentRequire(array $matches, $regex, $data)
    {

        return preg_replace($regex, "<?php \File::import('$1'); ?>", $data);

    }
    
    /**
     * componentRequireOnce
     *
     * @param  mixed $matches
     * @param  mixed $regex
     * @param  mixed $data
     * @return void
     */
    public function componentRequireOnce(array $matches, $regex, $data)
    {

        return preg_replace($regex, "<?php \File::oneImport('$1'); ?>", $data);

    }
    
    /**
     * componentImportTheme
     *
     * @param  mixed $matches
     * @param  mixed $regex
     * @param  mixed $data
     * @return void
     */
    public function componentImportTheme(array $matches, $regex, $data)
    {

        return preg_replace($regex, "<?php echo \View::theme('$1'); ?>", $data);

    }
    
    /**
     * componentForeach
     *
     * @param  mixed $matches
     * @param  mixed $regex
     * @param  mixed $data
     * @return void
     */
    public function componentForeach(array $matches, $regex, $data)
    {

        return preg_replace($regex, "<?php foreach($1): ?>", $data);

    }
    
    /**
     * componentEndForeach
     *
     * @param  mixed $matches
     * @param  mixed $regex
     * @param  mixed $data
     * @return void
     */
    public function componentEndForeach(array $matches, $regex, $data)
    {

        return preg_replace($regex, "<?php endforeach; ?>", $data);

    }
    
    /**
     * componentFor
     *
     * @param  mixed $matches
     * @param  mixed $regex
     * @param  mixed $data
     * @return void
     */
    public function componentFor(array $matches, $regex, $data)
    {

        return preg_replace($regex, "<?php for($1): ?>", $data);

    }
    
    /**
     * componentEndFor
     *
     * @param  mixed $matches
     * @param  mixed $regex
     * @param  mixed $data
     * @return void
     */
    public function componentEndFor(array $matches, $regex, $data)
    {

        return preg_replace($regex, "<?php endfor; ?>", $data);

    }
    
    /**
     * componentWhile
     *
     * @param  mixed $matches
     * @param  mixed $regex
     * @param  mixed $data
     * @return void
     */
    public function componentWhile(array $matches, $regex, $data)
    {

        return preg_replace($regex, "<?php while($1): ?>", $data);

    }
    
    /**
     * componentEndWhile
     *
     * @param  mixed $matches
     * @param  mixed $regex
     * @param  mixed $data
     * @return void
     */
    public function componentEndWhile(array $matches, $regex, $data)
    {

        return preg_replace($regex, "<?php endwhile; ?>", $data);

    }
    
    /**
     * componentIf
     *
     * @param  mixed $matches
     * @param  mixed $regex
     * @param  mixed $data
     * @return void
     */
    public function componentIf(array $matches, $regex, $data)
    {

        return preg_replace($regex, "<?php if($1): ?>", $data);

    }
    
    /**
     * componentElseIf
     *
     * @param  mixed $matches
     * @param  mixed $regex
     * @param  mixed $data
     * @return void
     */
    public function componentElseIf(array $matches, $regex, $data)
    {

        return preg_replace($regex, "<?php elseif($1): ?>", $data);

    }
    
    /**
     * componentElse
     *
     * @param  mixed $matches
     * @param  mixed $regex
     * @param  mixed $data
     * @return void
     */
    public function componentElse(array $matches, $regex, $data)
    {

        return preg_replace($regex, "<?php else: ?>", $data);

    }
    
    /**
     * componentEndIf
     *
     * @param  mixed $matches
     * @param  mixed $regex
     * @param  mixed $data
     * @return void
     */
    public function componentEndIf(array $matches, $regex, $data)
    {

        return preg_replace($regex, "<?php endif; ?>", $data);

    }
    
    /**
     * componentAssets
     *
     * @param  mixed $matches
     * @param  mixed $regex
     * @param  mixed $data
     * @return void
     */
    public function componentAssets(array $matches, $regex, $data)
    {

        return preg_replace($regex, "<?php echo \Assets::execute()->$1('$2'); ?>", $data);

    }
    
    /**
     * componentBuild
     *
     * @param  mixed $matches
     * @param  mixed $regex
     * @param  mixed $data
     * @return void
     */
    public function componentBuild(array $matches, $regex, $data)
    {

        
        return preg_replace($regex, "<?php echo \Build::execute()->$1('$2'); ?>", $data);

    }
    
    /**
     * componentUse
     *
     * @param  mixed $matches
     * @param  mixed $regex
     * @param  mixed $data
     * @return void
     */
    public function componentUse(array $matches, $regex, $data)
    {

        foreach($matches[0] as $k => $replace)
        {
            $class = down_line(array_pop(explode('\\', $matches[1][$k])));
            if(!empty($matches[2][0])) {
                $class = $matches[2][$k];
            }
            $data = str_replace($replace, '<?php $namespace'.$k." = '".$matches[1][$k]."'; $".$class.' = new $namespace'.$k.'(); ?>', $data);
        }        

        return $data;

    }

    
}