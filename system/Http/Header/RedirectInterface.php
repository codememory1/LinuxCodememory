<?php

namespace System\Http\Header;

/**
 * Interface RedirectInterface
 * @package System\Http\Header
 */
interface RedirectInterface
{

    /**
     * @param   bool $replace
     *
     * @return mixed
     */
    public function redirect($replace = true);

    /**
     * @return mixed
     */
    public function back();

    /**
     * @param $name
     * @param   null $code
     *
     * @return mixed
     */
    public function route($name, $code = null);

}