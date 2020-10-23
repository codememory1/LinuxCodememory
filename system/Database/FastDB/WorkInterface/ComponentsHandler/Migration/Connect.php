<?php

namespace System\Database\FastDB\WorkInterface\ComponentsHandler\Migration;

use System\Database\FastDB\WorkInterface\ComponentsHandler\Migration\MigrationInterfaces\ConnectionInterface;

/**
 * Connect
 */
class Connect implements ConnectionInterface
{
    
    /**
     * settings
     *
     * @var mixed
     */
    private $settings;
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct(?string $settingsPath = null)
    {
        
        $path = $settingsPath !== null ? $settingsPath : getcwd().'/settings-fastdb.xml';

        $this->settings = simplexml_load_file($path);

    }
    
    /**
     * getSettings
     *
     * @return void
     */
    public function getSettings()
    {

        return $this->settings;

    }
    
    /**
     * getServer
     *
     * @return void
     */
    public function getServer()
    {

        return $this->settings->connection->server;

    }
    
    /**
     * getPort
     *
     * @return void
     */
    public function getPort()
    {

        return $this->settings->connection->port;

    }
    
    /**
     * getUsername
     *
     * @return void
     */
    public function getUsername()
    {

        return $this->settings->connection->username;

    }
    
    /**
     * getPassword
     *
     * @return void
     */
    public function getPassword()
    {

        $pswd = $this->settings->connection->password;

        return $pswd;

    }

}