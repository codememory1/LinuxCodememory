<?php

namespace System\Support\Session\Exceptions;

use ErrorException;

/**
 * InvalidNameFlashException
 */
class InvalidNameFlashException extends ErrorException
{
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {

        parent::__construct('Flash Message name not specified');

    }

}