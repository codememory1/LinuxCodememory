<?php

namespace System\Database\FastDB\WorkInterface\ComponentsHandler\Migration;

use System\Database\FastDB\WorkInterface\ComponentsHandler\Migration\ {
    MigrationInterfaces\ConnectionInterface,
    MigrationTraits\LoggingTrait
};

/**
 * ExecuteSettingsXml
 */
class ExecuteSettingsXml
{

    use LoggingTrait;
    
    /**
     * connection
     *
     * @var mixed
     */
    private $connection;
    
    /**
     * __construct
     *
     * @param  mixed $connection
     * @return void
     */
    public function __construct(ConnectionInterface $connection)
    {
        
        $this->connection = $connection;

    }

}