<?php

namespace System\Plugins\CommonErrorsPlugins;

/**
 * Class InvalidKeySettingsPlugin
 * @package System\Plugins\CommonErrorsPlugins
 */
class InvalidKeySettingsPlugin
{

    /**
     * @var string
     */
	public $error;

    /**
     * InvalidKeySettingsPlugin constructor.
     *
     * @param $key
     */
	public function __construct($key)
	{
		
		$this->error['error'] = 'Ключ: '.$key.' в основных настройках плагина не найден.';
		
	}

    /**
     * @return string
     */
	public function __toString()
	{
		
		return $this->error['error'];
		
	}
	
}