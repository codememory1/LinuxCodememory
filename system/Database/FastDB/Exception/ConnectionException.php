<?php

namespace System\Database\FastDB\Exception;

use ErrorException;

/**
 * Class ConnectionException
 * @package System\Database\FastDB\Exception
 */
class ConnectionException extends ErrorException
{

    /**
     * ConnectionException constructor.
     *
     * @param $exception
     */
    public function __construct($exception) {
        
        parent::__construct($exception);
        
    }
    
}
