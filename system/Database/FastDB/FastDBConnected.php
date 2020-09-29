<?php

namespace System\Database\FastDB;

use System\Database\FastDB\FastDBConnection;

/**
 * Class FastDBConnected
 * @package System\Database\FastDB
 */
class FastDBConnected extends FastDBConnection
{
    
    /**
     * FastDBConnected constructor.
     *
     * @param   array $connection
     * @param $server
     */
    public function __construct(array $connection, $server) 
    {
        
        parent::__construct($connection, $server);
        
    }

    
}
