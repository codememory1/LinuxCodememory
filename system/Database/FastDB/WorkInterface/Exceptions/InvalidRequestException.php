<?php

namespace System\Database\FastDB\WorkInterface\Exceptions;

use ErrorException;

/**
 * InvalidRequestException
 */
class InvalidRequestException extends ErrorException
{

    public function __construct()
    {
        
        parent::__construct('[FastDB] `Invalid request. The page does not exist, or the request information is incorrect`');

    }

}

