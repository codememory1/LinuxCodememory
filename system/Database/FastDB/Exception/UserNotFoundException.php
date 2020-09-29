<?php

namespace System\Database\FastDB\Exception;

use ErrorException;

/**
 * Class UserNotFoundException
 * @package System\Database\FastDB\Exception
 */
class UserNotFoundException extends ErrorException
{

    /**
     * @var string
     */
    public $username;

    /**
     * UserNotFoundException constructor.
     *
     * @param $username
     */
    public function __construct($username) {
        
        parent::__construct("Для пользователя: <b>${username}</b>, доступ запрещен. Неверный логин или пароль. 🅵🅰🆂🆃🅳🅱");
        
        $this->username = $username;
        
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }
    
}
