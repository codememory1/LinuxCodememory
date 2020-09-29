<?php

namespace System\Http\Header;

use System\Http\Exception\InvalidHeaderCodeException;
use System\Http\Exception\InvalidHeaderException;

/**
 * Class Headers
 * @package System\Http
 */
class Header
{
	
	/* 1XX */
	const HTTP_CODE_CONTINUE = 100;
	const HTTP_CODE_SWITCHING_PROTOCOLS = 101;
	const HTTP_CODE_PROCESSING  = 102;
	
	/* 2XX */
	const HTTP_CODE_OK = 200;
	const HTTP_CODE_CREATED  = 201;
	const HTTP_CODE_ACCEPTED = 202;
	const HTTP_CODE_NON_AUTHORITATIVE_INFORMATION = 203;
	const HTTP_CODE_NO_CONTENT = 204;
	const HTTP_CODE_RESET_CONTENT = 205;
	const HTTP_CODE_PARTIAL_CONTENT = 206;
	const HTTP_CODE_MULTI_STATUS = 207;
	const HTTP_CODE_ALREADY_REPORTED = 208;
	const HTTP_CODE_IM_USED = 226;
	
	/* 3XXX */
	const HTTP_CODE_MULTIPLE_CHOICES = 300;
	const HTTP_CODE_MOVED_PERMANENTLY = 301;
	const HTTP_CODE_FOUND = 302;
	const HTTP_CODE_SEE_OTHER = 303;
	const HTTP_CODE_NOT_MODIFIED = 304;
	const HTTP_CODE_USE_PROXY = 305;
	const HTTP_CODE_RESERVED = 306;
	const HTTP_CODE_TEMPORARY_REDIRECT = 307;
	const HTTP_CODE_PERMANENT_REDIRECT = 308;
	
	/* 4XX */
	const HTTP_CODE_BAD_REQUEST = 400;
	const HTTP_CODE_UNAUTHORIZED = 401;
	const HTTP_CODE_PAYMENT_REQUIRED = 402;
	const HTTP_CODE_FORBIDDEN = 403;
	const HTTP_CODE_NOT_FOUND = 404;
	const HTTP_CODE_METHOD_NOT_ALLOWED = 405;
	const HTTP_CODE_NOT_ACCEPTABLE = 406;
	const HTTP_CODE_PROXY_AUTHENTICATION_REQUIRED = 407;
	const HTTP_CODE_REQUEST_TIMEOUT = 408;
	const HTTP_CODE_CONFLICT = 409;
	const HTTP_CODE_GONE = 410;
	const HTTP_CODE_LENGTH_REQUIRED = 411;
	const HTTP_CODE_PRECONDITION_FAILED = 412;
	const HTTP_CODE_PAYLOAD_TOO_LARGE = 413;
	const HTTP_CODE_URI_TOO_LONG = 414;
	const HTTP_CODE_UNSUPPORTED_MEDIA_TYPE = 415;
	const HTTP_CODE_RANGE_NOT_SATISFIABLE = 416;
	const HTTP_CODE_EXPECTATION_FAILED = 417;
	const HTTP_CODE_IM_A_TEAPOT = 418;
	const HTTP_CODE_AUTHENTICATION_TIMEOUT = 419;
	const HTTP_CODE_MISDIRECTED_REQUEST = 421;
	const HTTP_CODE_UNPROCESSABLE_ENTITY = 422;
	const HTTP_CODE_LOCKED = 423;
	const HTTP_CODE_FAILED_DEPENDENCY = 424;
	const HTTP_CODE_UPGRADE_REQUIRED = 426;
	const HTTP_CODE_PRECONDITION_REQUIRED = 428;
	const HTTP_CODE_TOO_MANY_REQUESTS = 429;
	const HTTP_CODE_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;
	const HTTP_CODE_RETRY_WITH = 449;
	const HTTP_CODE_UNAVAILABLE_FOR_LEGAL_REASONS = 449;
	const HTTP_CODE_CLIENT_CLOSED_REQUEST = 499;
	
	/* 5XX */
	const HTTP_CODE_INTERNAL_SERVER_ERROR = 500;
	const HTTP_CODE_NOT_IMPLEMENTED = 501;
	const HTTP_CODE_BAD_GATEWAY = 502;
	const HTTP_CODE_SERVICE_UNAVAILABLE = 503;
	const HTTP_CODE_GATEWAY_TIMEOUT = 504;
	const HTTP_CODE_HTTP_VERSION_NOT_SUPPORTED = 505;
	const HTTP_CODE_VARIANT_ALSO_NEGOTIATES = 506;
	const HTTP_CODE_INSUFFICIENT_STORAGE = 507;
	const HTTP_CODE_LOOP_DETECTED = 508;
	const HTTP_CODE_BANDWIDTH_LIMIT_EXCEEDED = 509;
	const HTTP_CODE_NOT_EXTENDED = 510;
	const HTTP_CODE_NETWORK_AUTHENTICATION_REQUIRED = 511;
	const HTTP_CODE_UNKNOWN_ERROR = 520;
	const HTTP_CODE_WEB_SERVER_IS_DOWN = 521;
	const HTTP_CODE_CONNECTION_TIMED_OUT = 522;
	const HTTP_CODE_ORIGIN_IS_UNREACHABLE = 523;
	const HTTP_CODE_A_TIMEOUT_OCCURRED = 524;
	const HTTP_CODE_SSL_HANDSHAKE_FAILED = 525;
	const HTTP_CODE_INVALID_SSL_CERTIFICATE = 526;

    /**
     * @var string[]
     */
	protected $http_text_code = [
		
		100 => 'Continue',
		101 => 'Switching Protocols',
		102 => 'Processing',
		
		200 => 'Ok',
		201 => 'Created',
		202 => 'Accespted',
		203 => 'Non-Authoritative Information',
		204 => 'No Content',
		205 => 'Reset Content',
		206 => 'Partial Content',
		207 => 'Multi-Status',
		208 => 'Already Reported ',
		226 => 'Im Used',
		
		300 => 'Multiple Choices',
		301 => 'Moved Permanently',
		302 => 'Found',
		303 => 'See Other',
		304 => 'Not Modified',
		305 => 'Use Proxy',
		306 => 'Reserved',
		307 => 'Temporary Redirect',
		308 => 'Permanent Redirect',
		
		400 => 'Bad Request',
		401 => 'Unauthorized',
		402 => 'Payment Required',
		403 => 'Forbidden',
		404 => 'Not Found',
		405 => 'Method Not Allowed',
		406 => 'Not Acceptable',
		407 => 'Proxy Authentication Required',
		408 => 'Request Timeout',
		409 => 'Conflict',
		410 => 'Gone',
		411 => 'Length Required',
		412 => 'Precondition Failed',
		413 => 'Payload Too Large',
		414 => 'URI Too Long',
		415 => 'Unsupported Media Type',
		416 => 'Range Not Satisfiable',
		417 => 'Expectation Failed',
		418 => 'I’m a teapot',
		419 => 'Authentication Timeout',
		421 => 'Misdirected Request',
		422 => 'Unprocessable Entity',
		423 => 'Locked',
		424 => 'Failed Dependency',
		426 => 'Upgrade Required',
		428 => 'Precondition Required',
		429 => 'Too Many Requests',
		431 => 'Request Header Fields Too Large',
		449 => 'Retry With',
		451 => 'Unavailable For Legal Reasons',
		499 => 'Client Closed Request',
		
		500 => 'Internal Server Error',
		501 => 'Not Implemented',
		502 => 'Bad Gateway',
		503 => 'Service Unavailable',
		504 => 'Gateway Timeout',
		505 => 'HTTP Version Not Supported',
		506 => 'Variant Also Negotiates',
		507 => 'Insufficient Storage',
		508 => 'Loop Detected',
		509 => 'Bandwidth Limit Exceeded',
		510 => 'Not Extended',
		511 => 'Network Authentication Required',
		520 => 'Unknown Error',
		521 => 'Web Server Is Down',
		522 => 'Connection Timed Out',
		523 => 'Origin Is Unreachable',
		524 => 'A Timeout Occurred',
		525 => 'SSL Handshake Failed',
		526 => 'Invalid SSL Certificate'
		
	];

    /**
     * @var array
     */
	protected $headers = [];

    /**
     * @var string
     */
	protected $protocol = '1.0';

    /**
     * @var int
     */
	public $status = 200;

    /**
     * @param   int $code
     *
     * @return bool
     */
	public function hasCode(int $code):bool
	{
		
		return (array_key_exists($code, $this->http_text_code)) ? true : false;
		
	}

    /**
     * @param $header
     *
     * @return array|bool|mixed|string
     */
	public function hasActiveHeaders($header)
	{
		
		return $this->all($header) ?? false;
		
	}

    /**
     * @param $header
     * @param   null $value
     *
     * @return $this
     * @throws InvalidHeaderCodeException
     */
	public function set($header, $value = null)
	{
		
		if(is_int($header))
		{
			if($this->hasCode($header) === true)
			{
				$renderHeaderCode = $this->http_text_code[$header];
			}
			else
				throw new InvalidHeaderCodeException($header);
		}
		else
			$renderHeaderCode = $header.': '.$value;
			
		$this->headers[(is_int($header)) ? $header : ''] = $renderHeaderCode;

		return $this;
		
	}

    /**
     * @param $value
     *
     * @return $this
     * @throws InvalidHeaderCodeException
     */
	public function setContentType($value)
	{
		
		$this->set('Content-Type', $value);
		
		return $this;
		
	}

    /**
     * @param $charset
     *
     * @return $this
     * @throws InvalidHeaderCodeException
     */
	public function setCharset($charset)
	{
		
		$this->set('Content-Type', 'charset='.down_line($charset));
		
		return $this;
		
	}

    /**
     * @param $responce
     *
     * @return $this
     * @throws InvalidHeaderCodeException
     */
	public function setFormatResponse(string $format)
	{
		
		$this->set('Content-Type', 'text/'.$format);
		
		return $this;
		
	}

    /**
     * @param $header
     *
     * @return array|mixed|string
     * @throws InvalidHeaderException
     */
	public function get($header)
	{
		
		if($this->hasActiveHeaders($header) === false)
			throw new InvalidHeaderException($header);
		
		return $this->all($header);
		
	}

    /**
     * @param   null $key
     *
     * @return array|mixed|string
     */
	public function all($key = null)
	{
		
		$headers = [];
		
		foreach(headers_list() as $header)
		{
			list($name, $value) = explode(':', $header);
			
			$headers[$name] = $value;
		}
		
		foreach(getallheaders() as $header => $value)
			$headers[$header] = $value;
		
		foreach(apache_request_headers() as $header => $value)
			$headers[$header] = $value;
		
		return (!is_null($key)) ? trim($headers[$key]) : $headers;
		
	}

    /**
     * @param   null $header
     *
     * @return bool
     */
	public function remove($header = null)
	{
		
		header_remove($header);
		
		return true;
		
	}

    /**
     * @return bool|void
     */
	public function shipped()
	{
		
		return headers_sent();
		
	}

    /**
     * @param $protocol
     *
     * @return $this
     */
	public function setVprotocol($protocol)
	{
		
		$this->protocol = $protocol;
		
		return $this;
		
	}
	
    /**
     * @return bool
     */
	public function sendHeaders():object
	{
		
		if(count($this->headers) > 0)
		{
			foreach($this->headers as $code => $header)
			{

				if(!is_int($code))
					header($header, true, $this->status);

				$status = (is_integer($code) && $code >= 100) ? $code : $this->status;
				$textCode = $this->http_text_code[$code ?: $this->status];

				$this->status = $status;
				
				header(sprintf('HTTP/%s %s %s', $this->protocol, $status, $textCode), true, $status);
			}

		}
		
		return $this;
		
	}
	
}