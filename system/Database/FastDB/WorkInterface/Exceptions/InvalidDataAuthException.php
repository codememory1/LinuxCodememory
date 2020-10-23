<?php

namespace System\Database\FastDB\WorkInterface\Exceptions;

use ErrorException;

/**
 * InvalidRequestException
 */
class InvalidDataAuthException extends ErrorException
{

    public function __construct()
    {
        
        parent::__construct('[FastDB] `Authorization data is incorrect`');

    }

}

