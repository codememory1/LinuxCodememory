<?php

namespace App\Models;

use System\Codememory\RegisterService;
use App\Models\Repositories\ConfigurationRepository;
use App\Models\Repositories\RepresentationRepository;
use App\Models\Handlers\HandlerEvents;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Flash;
use Store;
use Response;
use Validator;
use Redirector;

/**
 * RepresentationModel
 */
class RepresentationModel extends RegisterService
{
    
    /**
     * repr
     *
     * @var mixed
     */
    private $repr;
    
    /**
     * common
     *
     * @var mixed
     */
    private $common;
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {

        parent::__construct();

        $this->repr = new RepresentationRepository();
        $this->common = $this->model->load('Common');
        $this->handler = new HandlerEvents($this);
        
    }
        
    /**
     * getError
     *
     * @param  mixed $name
     * @return string
     */
    private function getError(?string $name = null)
    {

        $errors = [
            'notEvent'             => 'Событие не найдено.',
            'notDb'                => 'База Данных не найдена.',
            'notTable'             => 'Таблицы в указанной Базе Данных не существует.',
            'noSpecifiedDbOrTable' => 'Для работы с данным событием нужно указать БД и Таблицу.',
            'invalidRequestMethod' => 'Некорректный метод.',
            'invalidCountRequest'  => 'Кол-во запросов должно быть числом.'
        ];

        if($name === null) return $errors;
        else return $errors[$name];

    }
    
    /**
     * getEchoError
     *
     * @param  mixed $name
     * @return string
     */
    public function getEchoError(string $status, string $name):string
    {

        echo Response::arrayToJson(['status' => $status, 'message' => $this->getError($name)]);
        
        return $this->getError($name);

    }
        
    /**
     * checkEvents
     *
     * @return void
     */
    private function checkEvents()
    {

        $event = $this->request->post('event');

        if($this->repr->existsEvent($event) === false) {
            Flash::name('flash-error')->add('error', $this->getEchoError('error', 'notEvent'));
        } else {
            return $this->existsDbname();
        }

    }
    
    /**
     * existsDbname
     *
     * @return void
     */
    private function existsDbname()
    {

        $dbname = $this->request->post('dbname');
        if($dbname !== null && !empty($dbname)) {
            
            if($this->common->existsDb($dbname) === false) {
                
                Flash::name('flash-error')->add('error', $this->getEchoError('error', 'notDb'));
            } else {
                return $this->existsTable($dbname);
            }
        } 

        return true;
        
    }
    
    /**
     * existsTable
     *
     * @param  mixed $dbname
     * @return void
     */
    private function existsTable(string $dbname)
    {

        $table = $this->request->post('table-name');

        if($this->common->existsTable($dbname, $table) === false)
        {
            Flash::name('flash-error')->add('error', $this->getEchoError('error', 'notTable'));
        } else {
            return true;
        }

    }
    
    /**
     * checkMethod
     *
     * @return void
     */
    private function checkMethod()
    {

        $methods = [
            'get', 'post'
        ];

        $validator = Validator::field('method', up_line($this->request->post('method-request')))
            ->with('method', function($validate) use ($methods) {
                $validate->validation(sprintf('only:(%s)', up_line(implode(',', $methods))))
                    ->setMessage($this->getError('invalidRequestMethod'));
            })
            ->make();
        
        if($validator->validated === false) {
            Flash::name('flash-error')->add('error', $validator->getError());

            return false;
        } else {
            return $this->checkMaxRequest();
        }

    }
    
    /**
     * checkMaxRequest
     *
     * @return void
     */
    private function checkMaxRequest()
    {

        if(!is_numeric($this->request->post('count-request'))) {
            Flash::name('flash-error')->add('error', $this->getError('invalidCountRequest'));
        } else {
            return true;
        }

    }
    
    /**
     * create
     *
     * @return void
     */
    public function create()
    {

        $path = $this->getPathServer($this->getFullServer('server-dir').'/'.sprintf('Representation/%s/%s', $this->getUsername(), 'Event_'.$this->request->post('event')));
 
        if($this->checkEvents() === true && $this->checkMethod() === true) {

            $methodHandler = 'event'.$this->request->post('event');
            $handler = $this->handler->$methodHandler();

            if(gettype($handler) === 'boolean' && $handler === true) {
                if(Store::exists($path.'event.fd')) {
                    Store::editJsonFile($path.'event.fd')
                        ->editJsonData(function($data) {
                            $data['case'][] = $this->repr->getExample();

                            return $data;
                        });
                        
                } else {
                    
                    Store::overwrite($path.'event', Response::arrayToJson(['case' => [$this->repr->getExample()]]), '.fd');
                }
            } else {
                Flash::name('flash-error')->add('error', $handler);
            }
        }
        
        Redirector::back()->redirect();

    }
    
    /**
     * getAll
     *
     * @return array
     */
    public function getAll():array
    {

        return $this->repr->getAllInfoEvents($this->getFullServer('server-dir'), $this->getUsername());

    }
    
    /**
     * edit
     *
     * @param  mixed $event
     * @param  mixed $callback
     * @return void
     */
    public function edit(string $event, callable $callback)
    {

        $pathFile = $this->getPathServer($this->getFullServer('server-dir')).'Representation/%s/Event_%s/event.fd';
        $fullPath = sprintf($pathFile, $this->getUsername(), $event);
// debug($fullPath);
        Store::editJsonFile($fullPath)->editJsonData($callback);

    }
    
    /**
     * send
     *
     * @param  mixed $method
     * @param  mixed $url
     * @return void
     */
    public function send(string $method, string $url):array
    {

        $client = new Client();

        try {
            $response = $client->request($method, $url);

            return [
                'statusCode'   => $response->getStatusCode(),
                'responseText' => (string) $response->getBody()
            ];

        } catch(ClientException $e) {
            $statusCode = $e->getResponse()->getStatusCode();

            return [
                'statusCode'   => $statusCode,
                'responseText' => null
            ];
        }

    }
    
    /**
     * execRepresentation
     *
     * @param  mixed $event
     * @return void
     */
    public function execRepresentation(string $event)
    {

        $this->edit($event, function($datas) {
            foreach($datas['case'] as $k => $data)
            {
                $handler = function() use ($datas, $k, $data){
                    $result = $this->send($data['request-method'], $data['url-script']);

                    return [
                        'key'    => $k,
                        'result' => [
                            'response'   => $result['responseText'],
                            'statusCode' => $result['statusCode'],
                            'requests'   => $data['requests'] + 1
                        ]
                    ];
                };

                if($data['max-request'] >= 0) {
                    if($data['requests'] < $data['max-request']) {
                        
                        $result = $handler();

                        foreach($result['result'] as $kEdit => $value)
                        {
                            $datas['case'][$k][$kEdit] = $value;
                        }
                    }
                } else {
                    $result = $handler();

                    foreach($result['result'] as $kEdit => $value)
                    {
                        $datas['case'][$k][$kEdit] = $value;
                    }
                }
            }

            return $datas;
        });

    }

    /**
     * __call
     *
     * @param  mixed $method
     * @param  mixed $argc
     * @return void
     */
    public function __call($method, $argc)
    {

        return call_user_func_array([new ConfigurationRepository(), $method], $argc);

    }

}