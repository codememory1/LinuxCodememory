<?php

namespace System\Plugins\CommonErrorsPlugins;

/**
 * Class InvalidKeyInformationPlugin
 * @package System\Plugins\CommonErrorsPlugins
 */
class InvalidKeyInformationPlugin
{

    /**
     * @var string
     */
	public $error;

    /**
     * InvalidKeyInformationPlugin constructor.
     */
	public function __construct()
	{
		
		$this->error['error'] = 'Не вся информация указана о плагине.';
		
	}

    /**
     * @return string
     */
	public function __toString()
	{
		
		return $this->error['error'];
		
	}
	
}