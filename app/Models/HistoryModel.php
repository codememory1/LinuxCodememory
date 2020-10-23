<?php

namespace App\Models;

use System\Codememory\RegisterService;
use App\Models\Repositories\ConfigurationRepository;
use Store;
use Response;

/**
 * DatabaseModel
 * @package System\Codememory
 */
class HistoryModel extends RegisterService
{

    /**
     * conf
     *
     * @var mixed
     */
    private $conf;
    
    /**
     * common
     *
     * @var mixed
     */
    private $common;
    
    /**
     * create
     *
     * @var mixed
     */
    private $create;
        
    /**
     * template
     *
     * @var mixed
     */
    private $template;
    
    /**
     * dateCreateHistory
     *
     * @var mixed
     */
    private $dateCreateHistory = '0000-00-00 00:00';
    
    /**
     * dataSendUser
     *
     * @var array
     */
    private $dataSendUser = [
        'server'   => null,
        'port'     => null,
        'username' => null
    ];
    
    /**
     * formatTemplte
     *
     * @var string
     */
    private $formatTemplte = 'array';
    
    /**
     * dataSendHistory
     *
     * @var array
     */
    private $dataSendHistory = [];

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        
        parent::__construct();
        $this->conf = new ConfigurationRepository();
        $this->common = $this->model->load('Common');
        $this->create = $this->model->load('CreateFiles');

    }

    /**
     * getError
     *
     * @param  mixed $error
     * @return string
     */
    private function getError(string $error):string
    {

        $errors = [
            'success_delete_history' => 'История с индитификатором %s удалена.',
            'invalid_id_history'     => 'История с индитификатором %s не найдена.'
        ];

        if($this->request->get('json')) echo Response::arrayToJson(['response' => $errors[$key]]);

        return $errors[$error];

    }
        
    /**
     * getErrorToJson
     *
     * @param  mixed $status
     * @param  mixed $key
     * @param  mixed $add
     * @return void
     */
    private function getErrorToJson($status, $key, array $add = [])
    {
        
        $data = [
            'status'  => $status,
            'message' => $this->getError($key)
        ];

        if(count($add) > 0) {
            foreach($add as $k => $v)
            {
                $data[$k] = $v;
            }
        }

        return Response::arrayToJson($data);

    }
    
    /**
     * getNumberNotRead
     *
     * @return void
     */
    public function getNumberNotRead()
    {

        $all = $this->getAll();
        $count = 0;

        foreach($all as $history)
        {
            if($history['is-ready'] === false) $count++;
        }

        return $count === 0 ? null : $count;

    }
    
    /**
     * create
     *
     * @param  mixed $title
     * @param  mixed $callback
     * @return void
     */
    public function create(string $title, callable $callback)
    {

        $this->template = null;
        $this->dateCreateHistory = '0000-00-00 00:00';
        $this->dataSendUser['server'] = null;
        $this->dataSendUser['port'] = null;
        $this->dataSendUser['username'] = null;

        call_user_func($callback, $this);

        $dataHistory = $this->generateDataHistory($title);
        $this->dataSendHistory = $dataHistory;

        return $this;

    }
    
    /**
     * setTemplate
     *
     * @param  mixed $content
     * @return void
     */
    public function setTemplate($content)
    {

        $this->template = $content;
        $this->formatTemplte = 'string';

        return $this;

    }
    
    /**
     * setTemplateSpecialHtml
     *
     * @return void
     */
    public function setTemplateSpecialHtml($content)
    {

        $this->template = htmlspecialchars($content);
        $this->formatTemplte = 'string';

        return $this;

    }
    
    /**
     * setTemplateHtml
     *
     * @param  mixed $template
     * @return void
     */
    public function setTemplateHtml(array $template)
    {

        $this->template = htmlspecialchars($template);
        $this->formatTemplte = 'array';

        return $this;

    }
    
    /**
     * setDateCreateHistory
     *
     * @param  mixed $date
     * @return void
     */
    public function setDate(string $date)
    {

        $this->dateCreateHistory = $date;

        return $this;

    }
    
    /**
     * sendHistoryUser
     *
     * @param  mixed $server
     * @param  mixed $port
     * @param  mixed $username
     * @return void
     */
    public function setUserData(string $server, int $port, string $username)
    {

        $this->dataSendUser = [
            'server'   => $server,
            'port'     => $port,
            'username' => $username
        ];

        return $this;

    }
    
    /**
     * generateDataHistory
     *
     * @param  mixed $titleHistory
     * @return void
     */
    private function generateDataHistory(string $titleHistory)
    {

        $data = [
            'sender'           => $this->getUsername(),
            'sender-server'    => $this->getFullServer('server-watch'),
            'is-ready'         => false,
            'format-template'  => $this->formatTemplte,
            'title-history'    => $titleHistory,
            'template-history' => $this->template,
            'date-send'        => $this->dateCreateHistory
        ];

        return $data;

    }
    
    /**
     * sendHistory
     *
     * @return void
     */
    public function sendHistory()
    {
        Store::editJsonFile($this->getPathHistory($this->dataSendUser['server'].'-'.$this->dataSendUser['port'], $this->dataSendUser['username']).'history-data.fd')
            ->editJsonData(function($data) {
                $data[] = $this->dataSendHistory;

                return $data;
            });

    }
    
    /**
     * getAll
     *
     * @return void
     */
    public function getAll()
    {

        $historys = Response::jsonToArray(Store::getApi($this->getPathHistory($this->getFullServer('server-dir'), $this->getUsername()).'history-data.fd'));

        return $historys;

    }
        
    /**
     * updateStatusReady
     *
     * @return void
     */
    public function updateStatusReady()
    {

        Store::editJsonFile($this->getPathHistory($this->getFullServer('server-dir'), $this->getUsername()).'history-data.fd')->editJsonData(function($data) {
            foreach($data as $k => $history)
            {
                $data[$k]['is-ready'] = true;
            }

            return $data;
        });

    }
    
    /**
     * deleteHistory
     *
     * @param  mixed $id
     * @return void
     */
    public function deleteHistory(int $id)
    {

        Store::editJsonFile($this->getPathHistory($this->getFullServer('server-dir'), $this->getUsername()).'history-data.fd')->editJsonData(function($data) use ($id) {
            if(isset($data[$id])) {
                unset($data[$id]);

                echo sprintf($this->getErrorToJson('success', 'success_delete_history'), $id); 
            } else {
                echo sprintf($this->getErrorToJson('error', 'invalid_id_history'), $id); 
            }

            return $data;
        });

    }

    /**
     * __call
     *
     * @param  mixed $name
     * @param  mixed $arguments
     * @return void
     */
    public function __call($name, $arguments)
    {
        
        return call_user_func_array([$this->conf, $name], $arguments);

    }

}