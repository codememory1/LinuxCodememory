<?php

namespace System\Http;

use http\QueryString;
use System\Http\Exception\RequestProtectionException as Protection;
use System\Http\Exception\CodeUrlException;
use Session;
use Server;
use Random;
use Response;

/**
 * Class Request
 * @package System\Support
 */
class Request
{

    /**
     * @var array|int|string
     */
    private $resultMethod;

    /**
     * @var array
     */
    private $protections = [
		
		'html'  => false,
		'trim'  => false,
        'token' => false
		
    ];

    /**
     * @var array
     */
    private $methods = [
        
        'POST' => 'post',
        'GET'  => 'get'
        
    ];
	
	/**
     * @var string
     */
    private $nameUploadFile;
	
	/**
     * @var int
     */
	private $maxLoadFile = 1;
	
	/**
     * @var int
     */
	private $maxSizeMb = 7;
	
	/**
     * @var string
     */
	private $typeUploadFile;
	
	/**
     * @var array
     */
	private $errorUpload = [];

    /**
     * @var string
     */
	private $sendUri;

    /**
     * @var string|array|integer
     */
	private $responseCurl;
		
	/**
	 * setKey
	 *
	 * @var mixed
	 */
	private $setKey;
		
	/**
	 * setValue
	 *
	 * @var mixed
	 */
	private $setValue;
		
	/**
	 * setStatus
	 *
	 * @var mixed
	 */
	private $setStatus;
	
	/**
     * @var array
     */
	private $arrayNameUploadFile = [];
		
	/**
	 * statusProtection
	 *
	 * @var array
	 */
	private $statusProtection = [
		'status'  => 1,
		'message' => 'Некорректный токен запроса.'
	];

    /**
     * @param $method
     *
     * @return bool
     */
    private function hasMethod($method)
    {
        
        return (array_key_exists($method, $this->methods)) ? true : false;
        
    }

    /**
     * Response POST|GET
     *
     * @return array|int|string
     */
    public function give($protection_callback = null)
    {
        
		return $this->resultMethod;
		
        $protection_callback;
		
		$this->resultMethod = null;
		$this->protections['html'] = false;
		$this->protections['trim'] = false;
		$this->protections['token'] = false;
		
    }
		
	/**
	 * getArrayProtection
	 *
	 * @param  mixed $message
	 * @return void
	 */
	public function getArrayProtection($message = null)
	{
		
		(!is_null($message)) ? $this->statusProtection['message'] = $message : null;
		
		return (object) $this->statusProtection;
		
	}

    /**
     * Protection Request
     *
     * @param   bool $html
     * @param   bool $trim
     * @param   bool $protection_token
     *
     * @return $this
     */
    public function protection(bool $html = true, bool $trim = true, bool $protection_token = false)
    {
        
        $this->protections['html'] = $html;
        $this->protections['trim'] = $trim;
        $this->protections['token'] = $protection_token;
        
        return $this;
        
    }
		
	/**
	 * processingToken
	 *
	 * @param  mixed $methodText
	 * @param  mixed $methodGlobal
	 * @return void
	 */
	private function processingToken($methodText, $methodGlobal):void
	{

		if(Server::get('REQUEST_METHOD') == up_line($methodText) && 
		   $this->protections['token'] === true)
		{
			if(isset($methodGlobal['cdm_token']) != Session::get('PROTECTION-TOKEN'))
				$this->statusProtection['status'] = 0;
		}
		
	}
		
	/**
	 * processingProtectionVar
	 *
	 * @param  mixed $isName
	 * @return void
	 */
	private function processingProtectionVar($isName)
	{
		
		$result = ($this->protections['html'] === true && 
				   !is_array($isName)) ? 
			htmlspecialchars($isName, ENT_QUOTES | ENT_HTML5) : 
		$isName;
		$fullResult = ($this->protections['trim'] === true && 
				   !is_array($isName)) ? 
			trim($result) : 
		$result;
		
		return $fullResult;
		
	}
		
	/**
	 * methodRequestProcessing
	 *
	 * @param  mixed $name
	 * @param  mixed $withToken
	 * @param  mixed $methodGlobal
	 * @param  mixed $methodText
	 * @return void
	 */
	private function methodRequestProcessing($name = null, bool $withToken = false, $methodGlobal, $methodText):void
	{
		
		if($this->hasMethod(up_line($methodText)) === true)
        {
			
			$methodGlobalName = $methodGlobal[$name] ?? null;
			
            $isName = (is_null($name) || empty($name)) ? 
				$methodGlobal : 
			$methodGlobalName;
            
            $result = $this->processingProtectionVar($isName);
			
            $this->processingToken($methodText, $methodGlobal);
			
			if($withToken == false)
			{
				if(isset($result['cdm_token']))
					unset($result['cdm_token']);
			}
			
            $this->resultMethod = $result;
            
        }
		
	}
	
    /**
     * Get POST
     *
     * @param   null $name
     * @param   null $withToken
     *
     * @return $this
     * @throws Protection
     */
    public function post($name = null, bool $withToken = false)
    {
		
        $this->methodRequestProcessing($name, $withToken, $_POST, 'post');
		
		return $this;
		
    }
	
    /**
     * get $_GET
     *
     * @param   null $name
     * @param   false $withToken
     *
     * @return $this
     * @throws Protection
     */
    public function get($name = null, bool $withToken = false)
    {
        
        $this->methodRequestProcessing($name, $withToken, $_GET, 'get');
		
		return $this;
		
    }
		
	/**
	 * all
	 *
	 * @return array
	 */
	public function all():object
	{
		
		$params = func_get_args();
		
		$result = [];
		
		if(count($params) > 0)
		{
			foreach($params as $param)
			{
				(array_key_exists($param, $_REQUEST)) ? $result[$param] = $_REQUEST[$param] : null;
			}
		}
		else $result = $_REQUEST;

		unset($result[1]);

		$this->resultMethod = $result;
		
		return $this;
		
	}
	
	/**
	 * ignore
	 *
	 * @param  mixed $key
	 * @return void
	 */
	public function ignore(...$key)
	{

		$data = $this->resultMethod;

		foreach($key as $ignore)
		{
			unset($data[$ignore]);
		}
		
		$this->resultMethod = $data;

		return $this;

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

		$newArrayFile[$nameInput] += $this->addMethodsFiles($nameInput);
		
		$this->resultMethod = (object) $newArrayFile[$nameInput];
		
		return $this;
		
	}
		
	/**
	 * addMethodsFiles
	 *
	 * @param  mixed $nameInput
	 * @return void
	 */
	private function addMethodsFiles($nameInput)
	{
		
		$newArrayFile = [];
		
		foreach($_FILES[$nameInput]['name'] as $name)
		{
			$newArrayFile['hash_name'][] = Random::randAny(20);

			$newArrayFile['type'][] = pathinfo($name)['extension'] ?? null;

		}
		
		return $newArrayFile;
		
	}
		
	/**
	 * isToken
	 *
	 * @return string
	 */
	public function isToken():string
	{
		
		$this->protection(true, true, true)->post()->give(remove_protection_token());
		
		return ($this->getArrayProtection()->status === 0) ? 
			Response::arrayToJson(['protectionToken' => false]) : 
		Response::arrayToJson(['protectionToken' => true]);
		
	}
	
    /**
     * Add new param method
     *
     * @param $value
     *
     * @return $this
     */
    public function posts($key, $value = null)
	{
		
		$this->setStatus = 'POST';
		
		$this->setKey = $key;
		$this->setValue = $value;
		
		return $this;
		
	}
		
	/**
	 * gets
	 *
	 * @param  mixed $key
	 * @param  mixed $value
	 * @return void
	 */
	public function gets($key, $value = null)
	{
		
		$this->setStatus = 'GET';
		
		$this->setKey = $key;
		$this->setValue = $value;
		
		return $this;
		
	}
		
	/**
	 * set
	 *
	 * @return void
	 */
	public function set()
	{
		
		$this->setStatus == 'POST' ? 
			$_POST[$this->setKey] = $this->setValue : 
		$_GET[$this->setKey] = $this->setValue;
		
	}
		
	/**
	 * remove
	 *
	 * @return void
	 */
	public function remove()
	{
		
		if($this->setStatus == 'POST')
			unset($_POST[$this->setKey]);
		else
			unset($_GET[$this->setKey]);
		
	}
    
	/*
	* Curl request
	*/

    /**
     * Send Curl
     *
     * @param   null $uri
     *
     * @return $this
     */
	public function send($uri = null)
	{
		
		$uri = curl_init($uri);
		
		$this->sendUri = $uri;
		
		return $this;
		
	}

    /**
     * Options send Curl Array
     *
     * @param   array $oprions
     *
     * @return $this
     */
	public function options(array $oprions)
	{
		
		curl_setopt_array($this->sendUri, $oprions);
		
		return $this;
		
	}

    /**
     * Option send Curl
     *
     * @param $option
     * @param   null $value
     *
     * @return $this
     */
	public function option($option = null, $value = null)
	{
		
		curl_setopt($this->sendUri, CURLOPT_RETURNTRANSFER, true);
		
		(!is_null($option)) ? curl_setopt($this->sendUri, $option, $value) : null;
		
		return $this;
		
	}

    /**
     * Error Curl int|string
     *
     * @param   string $code
     *
     * @return int|string
     * @throws CodeUrlException
     */
	public function codeErrorCurl($code = 'int')
	{
		
		if($code == 'int')
			return curl_errno($this->sendUri);
		
		if($code == 'string')
			return curl_error($this->sendUri);
		
		if($code != 'int' && $code != 'string')
			throw new CodeUrlException();
		
	}

    /**
     * Responce Curl
     *
     * @return $this
     */
	public function reply()
	{
		
		$responce = curl_exec($this->sendUri);
		$this->responseCurl = $responce;
		
		return $this;
		
	}

    /**
     * Close curl request
     *
     * @return mixed
     */
	public function close()
	{
		
		return $this->responseCurl;
		
		curl_close($this->sendUri);
		
		$this->sendUri = '';
		
	}
	
	
    /**
     * @param $who
     *
     * @return bool
     * @throws \ErrorException
     */
    private function hasFile($who)
    {

        if(!file_exists('../'.$who))
        {
            throw new \ErrorException(
                sprintf('Download file {%s} impossible. Invalid path or given file does not exist.', $who)
            );
        }

        return true;

    }

    /**
     * @return mixed
     */
	public function fullPatch():string
	{
		
		return Server::get('CONTEXT_DOCUMENT_ROOT');
		
	}
	
	/**
     * @param string $method
     *
     * @return bool
     */
	public function isMethod($method)
	{
		
		return (\Common::getMethod() == up_line($method)) ? 
			true : 
		false;
		
	}
	
}
