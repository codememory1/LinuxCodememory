<?php

namespace System\Database\FastDB;

use System\Database\FastDB\Connection;

/**
 * Class QueryBuilderFastDB
 * @package System\Database\FastDB
 */
class QueryBuilderFastDB
{

    /**
     * @var FastDBQueryExecution
     */
    private $fast;

    /**
     * QueryBuilderFastDB constructor.
     */
    public function __construct()
    {
        
        $this->fast = (new Connection())->connect;
        
    }

    /**
     * @return FastDBQueryExecution
     */
    public function db()
    {
        
        return $this->fast;
        
    }
    
}