<?php

namespace System\Codememory\CodememoryConfigurationLanguage;

/**
 * ConfigurationVarsCm
 */
class ConfigurationVarsCm
{
    
    /**
     * vars
     *
     * @var array
     */
    private $vars = [];
    
    /**
     * __construct
     *
     * @param  mixed $pathConfig
     * @return void
     */
    public function __construct($pathConfig)
    {

        require include_cm($pathConfig);

        $this->vars = $allVars;

    }
    
    /**
     * __get
     *
     * @param  mixed $var
     * @return void
     */
    public function __get($var)
    {
 
        return $this->vars[$var];

    }
    
    /**
     * __set
     *
     * @param  mixed $var
     * @param  mixed $value
     * @return void
     */
    public function __set($var, $value)
    {

        $this->vars[$var] = $value;

    }

}