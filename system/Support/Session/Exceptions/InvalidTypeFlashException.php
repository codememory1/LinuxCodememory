<?php

namespace System\Support\Session\Exceptions;

use ErrorException;

/**
 * InvalidNameFlashException
 */
class InvalidTypeFlashException extends ErrorException
{
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {

        parent::__construct('Message types not specified');

    }

}