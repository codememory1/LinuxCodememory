<?php

namespace System\Inc\Exceptions;

use ErrorException;

class InvalidArgumentConsinderException extends ErrorException
{

    public function __construct()
    {
        
        parent::__construct('No `system` key in argument consider');

    }

}