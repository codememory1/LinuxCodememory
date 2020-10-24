<?php

namespace System\Http;

use Session;
use Symfony\Component\HttpFoundation\Request;
use Server;
use Header;
use Response;

/**
 * NewRequest
 */
class NewRequest
{
    
    /**
     * receivedRequest
     *
     * @var array
     */
    private $receivedRequest = [];
    
    /**
     * token
     *
     * @var array
     */
    private $token = [];
    
    /**
     * request
     *
     * @var mixed
     */
    public $request;
        
    /**
     * uri
     *
     * @var mixed
     */
    private $uri;
    
    /**
     * method
     *
     * @var string
     */
    private $method = 'GET';
    
    /**
     * params
     *
     * @var array
     */
    private $params = [];

        /**
     * content
     *
     * @var mixed
     */
    private $content = null;
    
    /**
     * event
     *
     * @var string
     */
    private $event = null;
    
    /**
     * setRequest
     *
     * @var array
     */
    private $setRequest = [];
    
    /**
     * dataToken
     *
     * @var bool
     */
    private $removeDataToken = true;
    
    /**
     * withHeaderToken
     *
     * @var bool
     */
    private $withHeaderToken = true;
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {

        $this->request = new Request();

    }
    
    /**
     * setUri
     *
     * @param  mixed $uri
     * @return void
     */
    public function setUri(string $uri)
    {
        
        $this->uri = $uri;

        return $this;

    }
    
    /**
     * setMethod
     *
     * @param  mixed $method
     * @return void
     */
    public function setMethod(string $method)
    {

        $this->method = up_line($method);

        return $this;

    }
    
    /**
     * setParams
     *
     * @param  mixed $params
     * @return void
     */
    public function setParams(array $params)
    {

        $this->params = $params;

        return $this;

    }
    
    /**
     * setContent
     *
     * @param  mixed $content
     * @return void
     */
    public function setContent($content)
    {

        return $this->content = $content;

        return $this;

    }
    
    /**
     * create
     *
     * @param  mixed $cookies
     * @param  mixed $files
     * @param  mixed $server
     * @return void
     */
    public function create(array $cookies = [], array $files = [], array $server = [])
    {

        return $this->request->create($this->uri, $this->method, $this->params, $cookies, $files, $server, $this->content);

    }

    /**
     * request
     *
     * @param  mixed $method
     * @param  mixed $keys
     * @return void
     */
    private function request($method, array $keys)
    {
        $input = json_decode(file_get_contents('php://input'), true);
        
        if(is_array($input) && (count($input) > 0)) {
            foreach($input as $key => $data)
            {
                $method[$key] = $data;
            }
        }
        
        $dataRequest = null;

        if($this->removeDataToken === true)
        {
            unset($method['cdm_token']);
        }

        if(count($keys) > 0)
        {
            foreach($keys as $keyRequest)
            {
                if(array_key_exists($keyRequest, $method) === true)
                {
                    if(count($keys) == 1) $dataRequest = $method[$keyRequest];
                    else $dataRequest[$keyRequest] = $method[$keyRequest]; 
                }
            }
        }
        else $dataRequest = $method;

        return $dataRequest;

    }
    
    /**
     * get
     *
     * @param  mixed $keys
     * @return void
     */
    public function get(...$keys)
    {

        if($this->event == 'set_request')
        {
            $_GET += $this->setRequest;
        }

        if($this->event === null)
        {
            return $this->request($_GET, $keys);
        }

        $this->event = null;

    }
    
    /**
     * post
     *
     * @param  mixed $keys
     * @return void
     */
    public function post(...$keys)
    {

        if($this->event == 'set_request')
        {
            $_POST += $this->setRequest;
        }

        if($this->event === null)
        {
            return $this->request($_POST, $keys);
        }

        $this->event = null;

    }
    
    /**
     * all
     *
     * @param  mixed $keys
     * @return void
     */
    public function all(...$keys)
    {

        return $this->request($_REQUEST, $keys);

    }
    
    /**
     * files
     *
     * @param  mixed $file
     * @return void
     */
    public function files($file = null)
	{

		$newArrayFile = [];
		
		$nameInput = (is_null($file) || empty($file)) ? array_keys($_FILES)[0] : $file;
		
		if(!is_array($_FILES[$nameInput]['name']))
			foreach(array_keys($_FILES[$nameInput]) as $key)
				$newArrayFile[$nameInput][$key][] = $_FILES[$nameInput][$key];	
		else
			$newArrayFile[$nameInput] = $_FILES[$nameInput];
		
		$newArrayFile[$nameInput]['mime_type'] = $newArrayFile[$nameInput]['type'];
		
		unset($newArrayFile[$nameInput]['type']);

		$newArrayFile[$nameInput] += $this->addTypeFile($nameInput);
		
		return $newArrayFile[$nameInput];
		
	}
		
	/**
	 * addMethodsFiles
	 *
	 * @param  mixed $nameInput
	 * @return void
	 */
	private function addTypeFile($nameInput)
	{
		
		$newArrayFile = [];
		
		foreach($_FILES[$nameInput]['name'] as $name)
		{
			$newArrayFile['hash_name'][] = \Random::randAny(20);

			$newArrayFile['type'][] = pathinfo($name)['extension'] ?? null;

		}
		
		return $newArrayFile;
		
	}
    
    /**
     * set
     *
     * @param  mixed $key
     * @param  mixed $data
     * @return void
     */
    public function set($key, $data)
    {

        $this->event = 'set_request';
        $this->setRequest[$key] = $data;

        return $this;

    }
        
    /**
     * globalHandlerIgnoreRemove
     *
     * @param  mixed $keys
     * @param  mixed $data
     * @return void
     */
    private function globalHandlerIgnoreRemove(array $keys, $data)
    {

        if(count($keys) > 0)
        {
            foreach($keys as $key)
            {
                if(array_key_exists($key, $data))
                {
                    unset($data[$key]);
                }
            }
        }

    }

    /**
     * ignore
     *
     * @param  mixed $keys
     * @return void
     */
    public function remove(...$keys)
    {

        $this->globalHandlerIgnoreRemove($keys, $this->receivedRequest);

        return $this;

    }
        
    /**
     * removeDataToken
     *
     * @param  mixed $status
     * @return void
     */
    public function removeDataToken(bool $status = true)
    {

        $this->removeDataToken = $status;

        return $this;

    }

    /**
     * withToken
     *
     * @param  mixed $status
     * @return void
     */
    public function withToken()
    {

        $token = $this->removeDataToken(false)->all('cdm_token');
        $savedToken = Session::get('PROTECTION-TOKEN');

        $this->setHeader('Cdm-Token', $savedToken ?: 'null');

        $this->token['status'] = (strcmp($token, $savedToken) === 0);

        if($this->withHeaderToken === true)
        {
            $this->token['status'] = (strcmp($token, $savedToken) === 0 && strcmp($token, \Header::get('Cdm-Token')) === 0);
        }

        remove_protection_token();

        return $this;

    }
    
    /**
     * withHeaderToken
     *
     * @param  mixed $status
     * @return void
     */
    public function withHeaderToken(bool $status)
    {

        $this->withHeaderToken = $status;

        return $this;

    }
    
    /**
     * tokenSuccess
     *
     * @return void
     */
    public function statusToken()
    {

        return $this->token;

    }
    
    /**
     * getProtocol
     *
     * @return void
     */
    public function getProtocol()
    {

        return $this->request->getScheme();

    }
    
    /**
     * __call
     *
     * @param  mixed $method
     * @param  mixed $params
     * @return void
     */
    public function __call($method, $params)
    {

        return call_user_func_array([$this->request, $method], $params);

    }
    
    /**
     * setHeader
     *
     * @param  mixed $header
     * @param  mixed $value
     * @return void
     */
    public function setHeader(string $header, $value)
    {

        Header::set($header, $value)->sendHeaders();

        return $this;

    }
    

}