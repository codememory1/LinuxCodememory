<?php

namespace System\Database\FastDB\Exception;

use ErrorException;

/**
 * Class DbNotFoundException
 * @package System\Database\FastDB\Exception
 */
class DbNotFoundException extends ErrorException
{

    /**
     * @var string
     */
    public $dbname;

    /**
     * @var string
     */
    public $username;

    /**
     * DbNotFoundException constructor.
     *
     * @param $dbname
     * @param $username
     */
    public function __construct($dbname, $username) {
        
        parent::__construct("База данных: <b>${dbname}</b> для пользователя: <b>${username}</b> не существует. 🅵🅰🆂🆃🅳🅱");
        
        $this->dbname = $dbname;
        $this->username = $username;
        
    }

    /**
     * @return string
     */
    public function getDbName()
    {
        return $this->dbname;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
    
}
