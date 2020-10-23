<?php

namespace System\Database\FastDB\WorkInterface\ComponentsHandler\Migration\MigrationInterfaces;

interface ConnectionInterface
{
    
    /**
     * getSettings
     *
     * @return void
     */
    public function getSettings();
    
    /**
     * getServer
     *
     * @return void
     */
    public function getServer();
    
    /**
     * getUsername
     *
     * @return void
     */
    public function getUsername();
    
    /**
     * getPassword
     *
     * @return void
     */
    public function getPassword();

}