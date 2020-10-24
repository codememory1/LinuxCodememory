<?php

namespace App\Models\Repositories;

use Request;
use Response;
use Store;

/**
 * RepresentationRepository
 */
class RepresentationRepository
{
    
    /**
     * events
     *
     * @var array
     */
    private $events = [
        'Auth', 'CreateTable', 'CreateDatabase', 'AddRecord', 'DeleteRecord'
    ];
    
    /**
     * eventsWithDir
     *
     * @var array
     */
    private $eventsWithDir = [
        'Event_Auth', 'Event_CreateTable', 'Event_CreateDatabase', 'Event_AddRecord', 'Event_DeleteRecord'
    ];
    
    /**
     * getEventDir
     *
     * @param  mixed $eventName
     * @return void
     */
    public function getEventDir(string $eventName):?string
    {

        $directory = null;

        foreach($this->events as $key => $event) 
        {
            if($event === $eventName) {
                $directory = $this->eventsWithDir[$key];
            }
        }

        return $directory;

    }
    
    /**
     * existsEvent
     *
     * @param  mixed $eventName
     * @return bool
     */
    public function existsEvent(?string $eventName = null):bool
    {

        return in_array($eventName, $this->events);

    }
    
    /**
     * getInfoEvent
     *
     * @param  mixed $eventName
     * @param  mixed $server
     * @param  mixed $username
     * @return array
     */
    public function getInfoEvent(string $eventName, string $server, string $username):array
    {
       
        $generatePath = 'FastDB/Servers/%s/Representation/%s/Event_%s/event.fd';

        if(Store::exists(sprintf($generatePath, $server, $username, $eventName))) {
            return Response::jsonToArray(Store::getApi($generatePath));
        }

        return [];

    }
    
    /**
     * getAllInfoEvents
     *
     * @param  mixed $server
     * @param  mixed $username
     * @return array
     */
    public function getAllInfoEvents(string $server, string $username):array
    {

        $generatePath = 'FastDB/Servers/%s/Representation/%s/';
        $path = sprintf($generatePath, $server, $username);
        $scan = Store::scan($path);
        $data = [];

        if($scan !== [] && (is_array($scan))) {
            foreach($scan as $eventDir)
            {
                $pathEvent = $path.$eventDir.'/';

                if(Store::exists($pathEvent.'event.fd') === true) {
                    $apiData = Response::jsonToArray(Store::getApi($pathEvent.'event.fd'));
                    if(is_array($apiData)) {
                        foreach($apiData['case'] as $k => $value)
                        {
                            $data[] = $value;
                        }
                    }
                } 
            }
        }

        return $data;

    }
    
    /**
     * getExample
     *
     * @return array
     */
    public function getExample():array
    {

        return [
            'event'          => Request::post('event'),
            'name'           => Request::post('event-name'),
            'dbname'         => Request::post('dbname'),
            'table-name'     => Request::post('table-name'),
            'url-script'     => Request::post('url-script'),
            'request-method' => Request::post('method-request'),
            'max-request'    => (int) Request::post('count-request'),
            'requests'       => 0,
            'response'       => null,
            'statusCode'     => '-',
            'date-create'    => \Date::format('Y-m-d H:i')
        ];

    }

}