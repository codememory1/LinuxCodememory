<?php

use System\Codememory\AbstractComponent\View;
use Symfony\Component\VarDumper\VarDumper;
use System\Support\Random;
use System\Support\Session\Session;
use System\Http\Header\Header;
use System\Router\Router;
use System\Codememory\Components\Config\ConfigManager;
use System\Http\Header\Redirect;
use System\Languages\Translate;
use System\Http\Response;
use System\Validator\ValidatorHandler;
use System\Languages\Languages;
use System\Codememory\CodememoryConfigurationLanguage\ReinforcerCodememory as CompilerCM;

/**
 * Function View
 */
if (!function_exists('View')) {
    function view($view = null, $data = [])
    {
        if($view !== null) {
			View::render($view, $data);
		}

		return new View();
    }
}

/**
 * Function dd - dump(prin_r)
 */
if (!function_exists('dd')) {
    function dd(...$vars)
    {
        foreach ($vars as $var) {
            VarDumper::dump($var);
        }
    }
}

/**
 * Function type vars
 */
if (!function_exists('auto_type')) {
    function auto_type($var, $type)
    {
        $type = gettype($var);
    }
}

/**
 * Function protection token - protection POST|GET requests
 */
if (!function_exists('protection_token')) {
    function protection_token()
    {
        $session = new Session();
		$header = new Header();
        $token = Random::randAny(36);
        
		$session->create('PROTECTION-TOKEN', $token);
		$header->set('Cdm-Token', $token)->sendHeaders();
        
        return $token;
    }
}

/**
 * Function delete protection session
 */
if (!function_exists('remove_protection_token')) {
    function remove_protection_token()
    {
        $session = new Session();
        
        $session->remove('PROTECTION-TOKEN');
    }
}

/**
 * Function url route
 */
if (!function_exists('route')) {
    function route($name, $params = [])
    {
        $router = new Router();
		
		return $router->route($name, $params);
		
    }
}

/**
 * Function url redirect
 */
if (!function_exists('redirect')) {
    function redirect($url)
    {
        $redirector = new Redirect();
		
		$redirector->his($url)->redirect();
		
    }
}


/**
 * Function config
 */
if (!function_exists('config')) {
    function config($config, $params = null)
    {
        $configManager = new ConfigManager();
		
		$cfg = $configManager->open($config);
		
		$data = $cfg;
		
		if(!is_null($params))
		{
			$paramsArr = explode('.', $params);
			
			foreach($paramsArr as $key)
			{
				$data = $cfg->data($key);
			}
			
		}
		
		return $data->get();
		
    }
}


/**
 * Function lang
 */
if (!function_exists('lang')) {
    function lang($e = null)
    {
		$lang = new Languages();

    	return $lang->getActiveLang($e);
		
    }
}

/**
 * Function Translate
 */
if (!function_exists('translate')) {
    function translate($of = null, $in = null, $content = null)
    {
        $translate = new Translate();
		
		if(func_get_args() === 0)
			return [];
		
		return $translate->translete($of, $in, $content)->receive();
    }
}

/**
 * Function Abort
 */
if (!function_exists('abort')) {
    function abort(int $code, $content = null)
    {
		$response = new Response();
		
        return $response->setResponseCode($code)
				->getContentResponseCode($content);
    }
}

/**
 * Function Regular
 */
if (!function_exists('regular')) {
    function regular($name = null)
    {
		
		$list = [
			'name'    => '/^[^\.\,]{3,30}$/iu',
			'phoneUA' => '/^38(\d){10}$/',
			'phoneRU' => '/^7(\d){10}$',
			'email'   => '/^([^\@\,\s]+)\@(gmail\.com|mail\.ru|urk\.net)$/i',
			'age'	  => '/^[6-60]+$/',
			'ip'	  => '/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/',
			'url'     => '/^(http|https)\:\/\/(.*?)$/iu'
		];
		
		return (array_key_exists($name, $list) === false) ? $list : $list[$name];
		
    }
}

/**
 * Function Validate
 */
if (!function_exists('validate')) {
    function validate($text, $validation, $valueValidation = null)
    {
		
		$validate = new ValidatorHandler();
		
		$status = false;
		
		switch($validation)
		{
				
			case 'EMAIL':
				$status = $validate->make(['email' => $text], ['email' => 'email'])->passed;
				break;
			case 'REQUIRED':
				$status = $validate->make(['required' => $text], ['required' => 'required'])->passed;
				break;
			case 'LENHT':
				$status = $validate->make(['lenht' => $text], ['lenht' => 'min:'.$valueValidation])->passed;
				break;
			case 'LENHT-TO':
				$status = $validate->make(['lenht' => $text], ['lenht' => 'between:1,'.$valueValidation])->passed;
				break;
			case 'LENHT-FROM-TO':
				$status = $validate->make(['lenht' => $text], ['lenht' => 'between:'.$valueValidation])->passed;
				break;
				
		}
		
		return $status;
		
    }
}

/**
 * Function include_cm full hash file lang CM
 */
if (!function_exists('include_cm')) {
	function include_cm($path, $addPath = null)
	{
		if($addPath === null)
			return dirname(getcwd()).'/'.CompilerCM::PATH_COMPILATION.md5($path).'.php';
		else
			return $addPath.CompilerCM::PATH_COMPILATION.md5($path).'.php';
		
	}
}

if (!function_exists('renameArrayKey')) {
	function renameArrayKey(array $array, $old_name, $new_name) 
	{
		$output = array();
			
		if (empty($array) || (empty($old_name) || !is_scalar($old_name)) || (empty($new_name) || !is_scalar($new_name))) {
			return array();
		}
			
		foreach ($array as $key => $value) {
			
			if (is_array($value)) {
				$output[$key] = renameArrayKey($value, $old_name, $new_name);
				continue;
			}
					
			$should_rename = $key === $old_name;
			$new_key = ($should_rename) ? $new_name : $key;
			$output[$new_key] = $value;              
		}
			
		return $output;
	}
}

if (!function_exists('replaceArrayValue')) {
	function replaceArrayValue(array $main, array $substitute, ...$substituteKyes):array
	{
		$newMain = [];
		$newSubstitute = [];
		$arrayData = [];
		$returnData = [];

		if($substituteKyes !== [] && array_key_exists(0, $substituteKyes) && (is_array($substituteKyes[0]))) $substituteKyes = $substituteKyes[0];

		foreach($main as $value) $newMain[] = $value;
		foreach($substitute as $value) $newSubstitute[] = $value;

		for($i = 0; $i <= count($newMain); $i++)
		{
			if(array_key_exists($i, $newSubstitute)) {
				$arrayData['main'][] = $newMain[$i];
				$arrayData['substitute'][] = $newSubstitute[$i];
			}
		}

		foreach($arrayData['main'] as $key => $valueData)
		{
			$value = (empty($valueData) || $valueData === null || $valueData == '') ? $arrayData['substitute'][$key] : $valueData;

			if($substituteKyes !== []) {
				if(array_key_exists($key, $substituteKyes)) $returnData[$substituteKyes[$key]] = $value;
				else $returnData[] = $value;
			} else {
				$returnData[] = $value;
			}
		}

		return $returnData;
	}
}
