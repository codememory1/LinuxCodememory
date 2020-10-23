<?php

namespace System\Codememory\Components\Fakers;

use File;

/**
 * Faker
 */
class Faker
{
    
    /**
     * uppercase
     *
     * @var bool
     */
    private $uppercase = false;
    
    /**
     * lang
     *
     * @var string
     */
    public $lang = 'EN';
        
    /**
     * config
     *
     * @var mixed
     */
    private $config;
    
    /**
     * rangeSymbol
     *
     * @var int
     */
    private $rangeSymbol = 5;
    
    /**
     * name
     *
     * @var string
     */
    public $name;
    
    /**
     * surname
     *
     * @var string
     */
    public $surname;
    
    /**
     * age
     *
     * @var int
     */
    public $age;
    
    /**
     * email
     *
     * @var string
     */
    public $email;
    
    /**
     * phone
     *
     * @var int
     */
    public $phone;
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        
        $this->config = File::import('system/Codememory/Components/Fakers/config.php');

    }

    /**
     * uppercase
     *
     * @return void
     */
    public function uppercase()
    {

        $this->uppercase = true;

        return $this;

    } 
    
    /**
     * lang
     *
     * @param  mixed $lang
     * @return void
     */
    public function lang(string $lang)
    {

        if(in_array(up_line($lang), $this->getListLang()) === true) {
            $this->lang = up_line($lang);
        }

        return $this;

    }
    
    /**
     * range
     *
     * @param  mixed $rangeSymbol
     * @return void
     */
    public function range(int $rangeSymbol)
    {

        $this->rangeSymbol = $rangeSymbol;

        return $this;

    }
    
    /**
     * getListLang
     *
     * @return void
     */
    public function getListLang()
    {

        return array_keys($this->config);

    }
    
    /**
     * handlers
     *
     * @return void
     */
    public function handlers()
    {

        $consonants = $this->config[$this->lang]['consonants'];
        $vowels = $this->config[$this->lang]['vowels'];
        $fakerData = [];

        for($i = 0; $i < $this->rangeSymbol / 2; $i++)
        {
            $fakerData[] = \Random::randHis(1, implode('', $consonants));
        }

        for($j = 0; $j < $this->rangeSymbol / 2; $j++)
        {
            array_splice($fakerData, $j + $j + 1, 0, [\Random::randHis(1, implode('', $vowels))]);
        }

        return (is_float($this->rangeSymbol / 2)) ? substr(implode('', $fakerData), 0, -1) : implode('', $fakerData);

    }

    public function getName()
    {

        

    }

    public function render()
    {

        return $this->handlers();

    }

}