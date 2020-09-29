<?php

namespace System\Http\Exception;

use ErrorException;
use Responce;

/**
 * Class ConnectionException
 * @package System\Database\FastDB\Exception
 */
class RequestProtectionException extends ErrorException
{

    /**
     * @var string
     */
    private $token;
    
    /**
     * ConnectionException constructor.
     *
     * @param $exception
     */
    public function __construct($token) {
        
        parent::__construct(Responce::json([1 => 'Некоректный токен запроса. Обновите страницу']));
        
        $this->token = $token;
        
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        
        return $this->token;
        
    }
    
}
