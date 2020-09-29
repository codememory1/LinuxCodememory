<?php

namespace System\Support;

use Server;

/**
 * Class Common
 * @package System\Support
 */
class Common 
{
    
    /**
     * ===_===_===_===_===_===_===_===_===_===_=
     * Эта функция получает GET параметры из URL
     * ===_===_===_===_===_===_===_===_===_===_=
     */
    /**
     * @return false|mixed|string
     */
    public static function getOptions()
    {
        $getUrl = Server::get('REQUEST_URI');
        
        if($getPosition = strpos($getUrl, '?')) {
            return substr($getUrl, $getPosition, -1);
        }

        return null;
    }
    
    /**
     * saveParams
     *
     * @param  mixed $url
     * @return void
     */
    public function saveParameters(string $url)
    {

        return $url.$this->getOptions();

    }

    /**
     * @param $url
     *
     * @return string|string[]|null
     */
    private static function parcerUrl($url) {

        return preg_replace('/^([^?]+)(\?.*?)?(#.*)?$/', '$1$3', $url);

    }

    /**
     * ===_===_===_===_===_===_===_===_===_===_===_
     * Эта функция получает URL без GET параметров
     * ===_===_===_===_===_===_===_===_===_===_===_
     *
     * @return false|string
     */
    public function getUrl()
    {
        
        $getUrl = ltrim(rtrim(self::parcerUrl(Server::get('REQUEST_URI')), '/'), '/');
        
        if($getPosition = strpos($getUrl, '?')) {

            $getUrl = substr($getUrl, 0, $getPosition);
            return $getUrl;

        }

        return $getUrl;

    }
    
    /**
     * getFullUrl
     *
     * @return void
     */
    public function getFullUrl()
    {

        $url = preg_replace('/(\?.*)?/', '', Server::get('REQUEST_URI'));

        return $this->getProtocol().'://'.$this->getHost().$url;

    }

    /**
     * @return string
     */
    public function defaultUrl()
    {

        return $this->getProtocol().'://'.Server::get('HTTP_HOST');

    }
    
    /**
     * ===_===_===_===_===_===_===_===_===_===
     * Эта функция получает Метод POST GET...
     * ===_===_===_===_===_===_===_===_===_===
     */
    /**
     * @return mixed
     */
    public function getMethod()
    {
        return Server::get('REQUEST_METHOD');
    }
    
    /**
     * ===_===_===_===_===_===_===_===_==
     * Эта функция получает HTTP протокол
     * ===_===_===_===_===_===_===_===_==
     */
    /**
     * @return mixed
     */
    public function getProtocol()
    {
        $protocol = Server::get('HTTPS') === 'on' ? 'https' : 'http';

        return $protocol;
    }
    
    /**
     * ===_===_===_===_===_===_===_===_===_===_===_=
     * Эта функция получает HOST пример: example.com
     * ===_===_===_===_===_===_===_===_===_===_===_=
     */
    /**
     * @return mixed
     */
    public function getHost()
    {
        return Server::get('HTTP_HOST');
    }

    /**
     * @return mixed
     */
    public function getIp()
    {

        return Server::get('REMOTE_ADDR');

    }
    
    /**
     * @param array $params
     * @param string $delimiter
     *
     * @return string
     */
    public function collectParameters(array $params, $delimiter = '&')
    {
        return '?'.http_build_query($params, '', $delimiter);
    }
		
	/**
	 * basicPatch
	 *
	 * @return void
	 */
	public function basicPatch()
	{
		
		return dirname(Server::get('PHP_SELF'));
		
    }
        
    /**
     * getPrevUrl
     *
     * @return void
     */
    public function getPrevUrl()
    {

        return Server::get('HTTP_REFERER');

    }
    
}
