<?php

namespace System\Http\Exception;

use ErrorException;

/**
 * Class ConnectionException
 * @package System\Database\FastDB\Exception
 */
class InvalidHeaderCodeException extends ErrorException
{

    /**
     * @var int
     */
    private $http_code;
    
    /**
     * ConnectionException constructor.
     *
     * @param $code
     */
    public function __construct($code) {
        
        parent::__construct("Код заголовка: <b>${code}</b> не существует.");
        
        $this->http_code = $code;
        
    }

    /**
     * @return mixed
     */
    public function getHttpCode()
    {
        
        return $this->http_code;
        
    }
    
}
