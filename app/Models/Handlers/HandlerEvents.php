<?php

namespace App\Models\Handlers;

use Request;

/**
 * HandlerEvents
 */
class HandlerEvents
{
        
    /**
     * errors
     *
     * @var array
     */
    private $model;

    /**
     * __construct
     *
     * @param  mixed $messages
     * @return void
     */
    public function __construct($model)
    {
        
        $this->model = $model;

    }
    
    /**
     * eventAuth
     *
     * @return bool
     */
    public function eventAuth():bool
    {

        return true;

    }
    
    /**
     * eventCreateTable
     *
     * @return bool
     */
    public function eventCreateTable():bool
    {

        return true;

    }
    
    /**
     * eventCreateDatabase
     *
     * @return bool
     */
    public function eventCreateDatabase():bool
    {

        return true;

    }
    
    /**
     * eventAddRecord
     *
     * @return bool
     */
    public function eventAddRecord():bool
    {

        return $this->eventDeleteRecord();
        
    }
    
    /**
     * eventDeleteRecord
     *
     * @return bool
     */
    public function eventDeleteRecord()
    {

        if(empty(Request::post('dbname')) || Request::post('table-name') === '') {
            return $this->model->getEchoError('error', 'noSpecifiedDbOrTable');
        }

        return true;

    }

}