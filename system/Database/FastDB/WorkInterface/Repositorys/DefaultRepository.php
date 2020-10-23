<?php

namespace System\Database\FastDB\WorkInterface\Repositorys;

/**
 * DefaultRepository
 */
class DefaultRepository
{
    
    /**
     * host
     *
     * @var string
     */
    protected $host = 'mydb.loc';
    
    /**
     * protocol
     *
     * @var string
     */
    protected $protocol = 'http';
    
    /**
     * getFullHost
     *
     * @return void
     */
    public function getFullHost()
    {

        return $this->protocol.'://'.$this->host;

    }

}