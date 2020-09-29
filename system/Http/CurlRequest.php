<?php

namespace System\Http;

/**
 * CurlRequest
 */
class CurlRequest
{
    
    /**
     * uri
     *
     * @var string
     */
    private $uri;
    
    /**
     * headers
     *
     * @var array
     */
    private $headers = [];
    
    /**
     * responseInfo
     *
     * @var mixed
     */
    private $responseInfo;
    
    /**
     * method
     *
     * @var string
     */
    private $methods = [
        'GET'   => false,
        'POST'  => true,
        'PUT'   => true
    ];
    
    /**
     * options
     *
     * @var array
     */
    public $options = [
        CURLOPT_URL            => null,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => false,
        CURLOPT_PUT            => false,
        CURLOPT_HTTPHEADER     => [],
    ];
    
    /**
     * init
     *
     * @param  mixed $uri
     * @return void
     */
    public function init(string $uri)
    {

        $this->uri = curl_init();
        $this->options[CURLOPT_URL] = $uri;

        return $this;

    }
    
    /**
     * setHeader
     *
     * @param  mixed $header
     * @param  mixed $value
     * @return void
     */
    public function setHeader(string $header, ?string $value)
    {

        $this->options[CURLOPT_HTTPHEADER][] = $header.':'.$value;

        return $this;

    }
    
    /**
     * setOpt
     *
     * @param  mixed $opt
     * @param  mixed $value
     * @return void
     */
    public function setOpt($opt, $value = null)
    {

        $this->options[$opt] = $value;

        return $this;

    }

    /**
     * method
     *
     * @param  mixed $method
     * @return void
     */
    public function method(string $method = 'GET')
    {

        $this->options[CURLOPT_POST] = $this->methods[up_line($method)];

        return $this;

    }
    
    /**
     * response
     *
     * @return void
     */
    public function response()
    {

        foreach($this->options as $k => $option)
        {
            if(empty($option) || @count($option) < 1)
            {
                unset($this->options[$k]);
            }
        }

        curl_setopt_array($this->uri, $this->options);
        $result = curl_exec($this->uri);
        curl_close($this->uri);

        return $result;
        
    }
    
    /**
     * info
     *
     * @return void
     */
    public function info($opt)
    {

        $this->responseInfo = curl_getinfo($this->uri, $opt);
        
        return $this->responseInfo;

    }

}