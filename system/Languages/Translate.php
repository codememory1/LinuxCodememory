<?php

namespace System\Languages;

use System\Languages\TranslateInterface;
use File;

/**
 * Class Translate
 * @package System\Languages
 */
class Translate implements TranslateInterface
{

    /**
     * @var string
     */
    private $translete;

    /**
     * @param $langOf
     * @param $langIn
     *
     * @return bool
     */
    private function handleLang($langOf, $langIn)
    {

        $config = config('ArrayTranslate');

        return (array_key_exists($langOf.' / '.$langIn, $config)) ? true : false;

    }

    /**
     * @param $langOf
     * @param $langIn
     * @param $content
     *
     * @return string|string[]
     */
    private function handle($langOf, $langIn, $content)
    {

        $config = config('ArrayTranslate');

        if($this->handleLang($langOf, $langIn) === true)
        {

            return $this->transleteHandle($langOf, $langIn, $content, $config);

        }

    }

    /**
     * @param $langOf
     * @param $langIn
     * @param $content
     * @param $config
     *
     * @return string|string[]
     */
    private function transleteHandle($langOf, $langIn, $content, $config)
    {

        foreach ($config[$langOf.' / '.$langIn] as $ofK => $inV)
        {

            $content = str_replace($ofK, $inV, $content);
            $content = $this->transleteHandleBig($langOf, $langIn, $content, $config);

        }

        return $content;

    }

    /**
     * @param $langOf
     * @param $langIn
     * @param $content
     * @param $config
     *
     * @return string|string[]
     */
    private function transleteHandleBig($langOf, $langIn, $content, $config)
    {

        foreach ($config[$langOf.' / '.$langIn] as $ofK => $inV)
        {

            $content = str_replace(up_line($ofK), one_up_line($inV), $content);

        }

        return $content;

    }

    /**
     * @param $langOf
     * @param $langIn
     * @param $content
     *
     * @return mixed|string|string[]
     */
    public function translete($langOf, $langIn, $content)
    {

        $this->translete = $this->handle(up_line($langOf), up_line($langIn), $content);

        return $this;

    }

    /**
     * @return mixed
     */
    public function receive()
    {

        return $this->translete;

    }

}