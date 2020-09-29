<?php

namespace System\Codememory\Console;

use System\Codememory\Console\ServersInterface;
use System\Codememory\CodememoryConfigurationLanguage\ConfigurationVarsCm as Configuration;
use PHPSocketIO\SocketIO;
use Workerman\Worker;

/**
 * SocketServers
 */
class SocketServers implements ServersInterface
{
    
    /**
     * list
     *
     * @var array
     */
    public $list = [];
    
    /**
     * conf
     *
     * @var mixed
     */
    private $conf;
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {

        $this->conf = new Configuration('config/Codememory/configuration');

    }
    
    /**
     * register
     *
     * @param  mixed $name
     * @param  mixed $class
     * @param  mixed $method
     * @return void
     */
    public function register($name, $class, $method)
    {

        $namespace = sprintf($this->conf->server['namespace'], $class);

        $this->list[$name]['class'] = $namespace;
        $this->list[$name]['method'] = $method;

        return $this;

    }
    
    /**
     * executes
     *
     * @return void
     */
    public function executes(int $port)
    {
        if(count($this->list) > 0)
        {
            $connect = new SocketIO($port);

            foreach($this->list as $name => $dataClass)
            {

                $method = $dataClass['method'];
                $class = $dataClass['class'];

                $object = new $class($connect);

                return $object->$method();

            }
            
        }

    }

}