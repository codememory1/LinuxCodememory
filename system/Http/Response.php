<?php

namespace System\Http;

use Header;
use Store;
use Redirector;

/**
 * Class Response
 * @package System\Http
 */
class Response 
{

    /**
     * @var string
     */
	protected $content;

    /**
     * @var int
     */
	protected $responseCode = 200;
	
	/**
	 * headers
	 *
	 * @var array
	 */
	private $headers = [];

    /**
     * @param   string $content
     *
     * @return $this|object
     */
	public function setContent($content):object
	{
		
		$this->content = $content ?? '';
		
		return $this;
		
	}

    /**
     * @return string
     */
	public function getContent():string
	{
		
		return $this->content;
		
	}
	
	/**
	 * sendContent
	 *
	 * @return void
	 */
	public function sendContent():void
	{
		
		echo $this->content;
		
	}
	
	/**
	 * headers
	 *
	 * @param  mixed $headers
	 * @param  mixed $value
	 * @return void
	 */
	public function headers(array $headers, array $value)
	{

		$this->headers['headers'] = $headers;
		$this->headers['values'] = $value;

		return $this;

	}
		
	/**
	 * send
	 *
	 * @return void
	 */
	public function send()
	{

		$this->setHeaders($this->headers['headers'], $this->headers['values'] ?? []);
		$this->sendContent();

		return true;

	}

    /**
     * @param   array $headers
     * @param   array $value
     *
     * @return bool
     */
	public function setHeaders(array $headers, array $value)
	{
		
		foreach($headers as $key => $header)
			Header::set($header, $value[$key])->sendHeaders();
		
		return true;
		
	}

    /**
     * @param   int $code
     *
     * @return $this|object
     */
	public function setResponseCode(int $code):object
	{
		
		$setHeader = Header::set($code)->sendHeaders();
		
		$this->responseCode = $setHeader->status;
		
		return $this;
		
	}

    /**
     * @return int
     */
	public function getResponseCode():int
	{
		
		return $this->responseCode;
		
	}
	
	/**
     * @param   string null $content
     *
     * @return bool
     */
	public function getContentResponseCode(string $content = null)
	{
		
		$code = $this->getResponseCode();
		$configResponseCode = config('Codememory.ErrorPages');
		
		$namespace = 'App\\Controllers\\';
		
		if(array_key_exists($code, $configResponseCode))
		{
			
			$error = config('Codememory.ErrorPages', $code);

			$controller = $error['Controller'];
			$method = $error['Method'];
			$file = $error['File'];

			if($controller !== null && $method !== null)
			{
				$fullNamespace = $namespace.$controller;
				$responseCode = (new $fullNamespace())->$method();
			}
			else
				$responseCode = ($file === null) ? $content : $file;
			
			return exit($responseCode);
			
		}
		
		return exit($content);
		
	}

    /**
     * @param   string $data
     *
     * @return array
     */
	public function jsonToArray(string $data)
	{
		
		return json_decode($data, true);
		
	}

    /**
     * @param   string $data
     *
     * @return object
     */
	public function jsonToObject(string $data):object
	{
		
		return json_decode($data, false);
		
	}
	
    /**
     * @param   array $data
     *
     * @return false|string|void
     */
	public function arrayToJson($data)
	{

		return json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
		
	}

    /**
     * @param $download_file
     * @param   null $rename
     */
	public function download($download_file, $rename = null)
	{
		
		$arrayNameFile = explode('/', $download_file);

        $nameDownload = (!is_null($rename)) ? $rename : array_pop($arrayNameFile);
		
        if(Store::exists($download_file) === true)
        {
			
			Header::setContentType('application/octet-stream')
				->set('Accept-Ranges', 'bytes')
				->set('Content-Length', filesize('../'.$download_file))
				->set('Content-Disposition', 'attachment; filename='.$nameDownload)->sendHeaders();
			
            readfile('../'.$download_file);
			
        }
		
	}

    /**
     * @param $url
     */
	public function redirect($url)
	{
		
		Redirector::his($url)->redirect();
		
	}
	
	/**
     * @return bool
     */
	public function isContinue()
	{
		
		return 1000 === $this->getResponseCode();
		
	}
	
    /**
     * @return bool
     */
	public function isNotFound()
	{
		
		return 404 === $this->getResponseCode();
		
	}

    /**
     * @return bool
     */
	public function isForbidden()
	{
		
		return 403 === $this->getResponseCode();
		
	}

    /**
     * @return bool
     */
	public function isIntervalServerError()
	{
		
		return 500 === $this->getResponseCode();
		
	}

    /**
     * @return bool
     */
	public function isOk()
	{
		
		return 200 === $this->getResponseCode();
		
	}

    /**
     * @return bool
     */
	public function isInformational()
	{
		
		return $this->getResponseCode() >= 100 && $this->getResponseCode() <= 102;
		
	}

    /**
     * @return bool
     */
	public function isSuccess()
	{
		
		return $this->getResponseCode() >= 200 && $this->getResponseCode() < 300;
		
	}

    /**
     * @return bool
     */
	public function isRedirection()
	{
		
		return $this->getResponseCode() >= 300 && $this->getResponseCode() <= 308;
		
	}

    /**
     * @return bool
     */
	public function isClientError()
	{
		
		return $this->getResponseCode() >= 400 && $this->getResponseCode() < 500;
		
	}

    /**
     * @return bool
     */
	public function isServerError()
	{
		
		return $this->getResponseCode() >= 500 && $this->getResponseCode() < 600;
		
	}
	
}