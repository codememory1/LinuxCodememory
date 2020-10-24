<?php

namespace System\Database\FastDB\WorkInterface\Exceptions;

use ErrorException;

/**
 * ForbidenRequestException
 */
class ForbidenRequestException extends ErrorException
{

    public function __construct()
    {
        
        parent::__construct('[FastDB] `The request was rejected. The reason why the request may be rejected: "Insufficient access rights, incorrect authorization data"`');

    }

}

