<?php

namespace System\Http\Exception;

use ErrorException;

/**
 * Class ConnectionException
 * @package System\Database\FastDB\Exception
 */
class InvalidHeaderException extends ErrorException
{

    /**
     * @var int
     */
    private $header;
    
    /**
     * ConnectionException constructor.
     *
     * @param $code
     */
    public function __construct($header) {
        
        parent::__construct("Заголовок: <b>${header}</b> не найден.");
        
        $this->header = $header;
        
    }

    /**
     * @return mixed
     */
    public function getHeader()
    {
        
        return $this->header;
        
    }
    
}
