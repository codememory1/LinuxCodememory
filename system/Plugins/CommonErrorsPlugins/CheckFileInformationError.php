<?php

namespace System\Plugins\CommonErrorsPlugins;

/**
 * Class CheckFileInformationError
 * @package System\Plugins\CommonErrorsPlugins
 */
class CheckFileInformationError
{

    /**
     * @var string
     */
	public $error;

    /**
     * CheckFileInformationError constructor.
     */
	public function __construct()
	{
		
		$this->error['error'] = 'Файл (InformationPlugin.xml) в плагине %s не найден.';
		
	}

    /**
     * @return string
     */
	public function __toString()
	{
		
		return $this->error['error'];
		
	}
	
}