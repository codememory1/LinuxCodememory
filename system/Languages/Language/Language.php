<?php

namespace System\Languages\Language;

use Url;
use Yml;
use Cookie;
use Env;

/**
 * Language
 * @package System\Languages\Language
 */
class Language
{
        
    /**
     * language
     *
     * @var array
     */
    private $language = [];
    
    /**
     * selectionLang
     *
     * @var string
     */
    private $selectionLang;
    
    /**
     * translates
     *
     * @var array
     */
    private $translates = [];
    
    /**
     * translatesOfFile
     *
     * @var array
     */
    private $translatesOfFile = [];
        
    /**
     * conf
     *
     * @var array
     */
    private $conf = [];
    
    /**
     * settings
     *
     * @var array
     */
    private $settings = [
        'langTime'      => 1,
        'numTranslates' => -1,
        'lineLength'    => 100 // 100%
    ];
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        
        $this->configurate();
        $this->defaultConfigurate();

    }
        
    /**
     * defaultConfigurate
     *
     * @return void
     */
    private function defaultConfigurate()
    {

        $this->selectionLang = down_line(Env::get('LANG_SITES'));

    }

    /**
     * configuration
     *
     * @return void
     */
    private function configurate()
    {

        require include_cm('config/Codememory/configuration');

        $this->conf = $allVars['language'];

    }

    /**
     * setLanguage
     *
     * @param  mixed $language
     * @return void
     */
    public function setLang(array $language)
    {

        $this->language = $language;

        return $this;

    }
    
    /**
     * changeLang
     *
     * @param  mixed $lang
     * @return void
     */
    public function changeLang(string $lang)
    {

        Cookie::create('lang', down_line($lang), $this->settings['langTime']);

        return down_line($lang);

    }

    /**
     * selectLang
     *
     * @param  mixed $lang
     * @return void
     */
    public function selectLang(string $lang)
    {

        $this->selectionLang = $lang;

        return $this;

    }

    /**
     * instantly
     *
     * @param  mixed $key
     * @param  mixed $translate
     * @return void
     */
    public function reverse(string $key, array $translate)
    {

        foreach($this->language as $keyLang => $lang)
        {
            $this->translates[down_line($lang)][$key] = $translate[$keyLang];
        }

        return $this->translates[down_line($this->selectionLang)][$key] ?? '';

    }
    
    /**
     * reverseFast
     *
     * @param  mixed $langs
     * @param  mixed $key
     * @param  mixed $translate
     * @return void
     */
    public function reverseFast(array $langs, string $key, array $translate)
    {

        $this->language = $langs;

        return $this->reverse($key, $translate);

    }
    
    /**
     * pathLangs
     *
     * @return void
     */
    private function pathLangs()
    {

        $path = sprintf($this->conf['path'].'%s/'.$this->conf['name'], $this->selectionLang);

        if(\Store::exists($path.'.yaml')) $path = sprintf($this->conf['path'].'%s/'.$this->conf['name'], $this->selectionLang);
        else $path = sprintf($this->conf['path'].'%s/'.$this->conf['name'], Env::get('LANG_SITES'));

        $this->translatesOfFile[$this->selectionLang] = Yml::open($path)->parse();
        
        return $this;

    }
    
    /**
     * set
     *
     * @param  mixed $key
     * @param  mixed $translate
     * @return void
     */
    public function set(string $key, string $translate)
    {

        $this->translatesOfFile[down_line($this->language)][$key] = $translate;

        return $this;

    }
    
    /**
     * get
     *
     * @param  mixed $key
     * @return void
     */
    public function get(string $key)
    {

        $this->pathLangs();

        $translateData = $this->translatesOfFile[$this->selectionLang][$key] ?? '';
        $length = round(iconv_strlen($translateData) * $this->settings['lineLength'] / 100);
        $translateData = mb_substr($translateData, 0, $length);

        if($this->settings['numTranslates'] !== -1) 
        {
            $index = array_search($key, array_keys($this->translatesOfFile[$this->selectionLang]));

            if($index > $this->settings['numTranslates']) return null;
            else return $translateData ?? null;
        }
        else return $translateData ?? null;
        
    }
    
    /**
     * settings
     *
     * @param  mixed $langTime
     * @param  mixed $numTranslates
     * @param  mixed $line_length
     * @return void
     */
    public function settings(int $langTime = 1, int $numTranslates = -1, int $line_length = 100)
    {

        $length = $line_length > 100 ? 100 : $line_length;
        $length = $length < 0 ? 0 : $length;

        $this->settings['langTime'] = $langTime;
        $this->settings['numTranslates'] = $numTranslates;
        $this->settings['lineLength'] = $length;

        return $this;

    }
    
    /**
     * getActiveLang
     *
     * @return void
     */
    public function getActiveLang()
    {

        return Cookie::get('lang') ?: $this->selectionLang;

    }

}
