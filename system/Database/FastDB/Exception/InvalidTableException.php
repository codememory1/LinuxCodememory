<?php

namespace System\Database\FastDB\Exception;

use ErrorException;

/**
 * Class InvalidTableException
 * @package System\Database\FastDB\Exception
 */
class InvalidTableException extends ErrorException
{

    /**
     * @var string
     */
    public $table;

    /**
     * @var string
     */
    public $dbname;

    /**
     * InvalidTableException constructor.
     *
     * @param $table
     * @param $dbname
     */
    public function __construct($table, $dbname) {
        
        parent::__construct("Таблица: <b>${table}</b>. Для базы данных: <b>${dbname}</b> не найдена. 🅵🅰🆂🆃🅳🅱");
        
        $this->table = $table;
        $this->dbname = $dbname;
        
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @return string
     */
    public function getDbName()
    {
        return $this->table;
    }
    
}
