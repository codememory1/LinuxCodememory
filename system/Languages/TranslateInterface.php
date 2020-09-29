<?php

namespace System\Languages;

/**
 * Interface TranslateInterface
 * @package System\Languages
 */
interface TranslateInterface
{

    /**
     * @param $langOf
     * @param $langIn
     * @param $content
     *
     * @return mixed
     */
    public function translete($langOf, $langIn, $content);

    /**
     * @return mixed
     */
    public function receive();

}