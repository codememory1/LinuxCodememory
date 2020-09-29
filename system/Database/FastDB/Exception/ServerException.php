<?php

namespace System\Database\FastDB\Exception;

use ErrorException;

/**
 * Class ServerException
 * @package System\Database\FastDB\Exception
 */
class ServerException extends ErrorException
{

    /**
     * @var string
     */
    public $server;

    /**
     * ServerException constructor.
     *
     * @param $server
     */
    public function __construct($server) {
        
        parent::__construct("Сервера: [${server}] не существует 🅵🅰🆂🆃🅳🅱");
        
        $this->server = $server;
        
    }

    /**
     * @return string
     */
    public function getServer()
    {
        return $this->server;
    }
    
}
