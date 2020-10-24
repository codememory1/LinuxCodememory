<?php

namespace System\Authentication;

use System\Authentication\RegistrationHandle;
use Jenssegers\Blade\Blade;
use System\Http\Request as CommonRequest;
use Validator;
use Session;
use Redirector;
use Random;
use Request;

/**
 * Class Registration
 * @package System\Authentication
 */
class Registration
{
	
	const SESSION_NAME_AUTH = 'CDM_AUTH';
	const SESSION_NAME_ERROR = 'ERROR_AUTHENTICATION';
	const SESSION_NAME_DATA_USER = 'DATA_USER_KEY-%s';
	const PATCH_VIEWS = 'system.Authentication.Views.Registration.';

    /**
     * @var bool
     */
	private $register_status = false;
	
	/**
     * @var object
     */
	private $request;
	
	 /**
     * @var array
     */
	private $inputs = [];
	
	/**
     * @var array
     */
	private $unique_data = [];
	
	/**
     * @var string
     */
	private $table;

    /**
     * @var array
     */
	private $settings = [
		
		'auth_after_register' => false
		
	];

    /**
     * Validate Rules - проверяет валидацию с добавлеными правилами
     *
     * @return $this
     */
    public function validate()
    {
        
		$this->register_status = false;
		
		$this->request = Request::protection(true, true, true)->post()->give(remove_protection_token());
		
		$request = [];
		
		$rules = [];
		
		foreach($this->inputs as $name => $rule)
		{
			$rules[$name] = $rule;
			$request[$name] = $this->request[$name];
		}

		$validate = Validator::make($request, $rules);

		if($validate->passed === false || count($validate->getMessage()) > 0)
		{
			Session::create(self::SESSION_NAME_ERROR, $validate->getMessage());
		
			Redirector::back()->redirect();
			$this->register_status = false;
		}
		else
			$this->register_status = true;
	
		return ($this->register_status === true) ? $this : null;
    }

    /**
     * Add Rules register - добавить новоле правила для регистрации
     *
     * @param $name
     * @param   array $rules
     * @param   array $messages
     *
     * @return $this
     */
	public function addRules($name, array $rules, array $messages = [])
	{
		
		$inputs = [$name => null];
		
		$fullRule = null;
		
		foreach($rules as $key => $rule)
		{
			
			$fullRule .= (isset($messages[$key])) ? $rule.'('.$messages[$key].')|' : $rule.'|';
			
		}
		
		$inputs[$name] .= substr($fullRule, 0, -1);
		
		$this->inputs += $inputs;
		
		return $this;
		
	}

    /**
     * Unique data in db - основные настройки регистрации
     *
     * @param   array $unique_data
     *
     * @return $this
     */
	public function basicSettings(array $unique_data = [])
	{
		
		$this->register_status = false;
		
		$this->unique_data = $unique_data;
		
		$handle = new RegistrationHandle($this->table);
		
		$statusCheckUnique = $handle->checkUnique($this->unique_data)->passed;
		
		if($statusCheckUnique === false || count($handle->checkUnique($unique_data)->getMessage()) > 0)
		{
			Session::create(self::SESSION_NAME_ERROR, $handle->checkUnique($unique_data)->getMessage());
		
			Redirector::back()->redirect();
			
			$this->register_status = false;
			
		}
		else
			$this->register_status = true;
		
		return ($this->register_status === true) ? $this : null;
		
	}

    /**
     * Settings register - настройки для регистрации
     *
     * @param $table
     * @param   bool $auth_after_register
     *
     * @return $this
     */
	public function settings($table, $auth_after_register = false)
	{
		
		$this->table = $table;
		$this->settings['auth_after_register'] = $auth_after_register;
		
		return $this;
		
	}

    /**
     * Create User and Add in db - выполнить регистрацию
     *
     * @param   array $keysDb
     * @param   array $data
     *
     * @return $this
     */
	public function register(array $keysDb, array $data)
	{
		
		$handle = new RegistrationHandle($this->table);
		
		if($this->register_status === true)
		{
			$handle->create($keysDb, $data);
		}
		
		return ($this->register_status === true) ? $this : null;
		
	}

    /**
     * Success Register - выполнить функцию после успешной регистрации
     *
     * @param $callback
     */
	public function successFull($callback)
	{
		
		if($this->register_status === true)
		{
			if(is_callable($callback))
				call_user_func($callback);
		}
		
	}

    /**
     * View Register - загрузить шаблон регистрации
     *
     * @param $view
     * @param   array $data
     */
	public function view($view, array $data = [])
	{
		
		$patch = str_replace('.', '/', self::PATCH_VIEWS);

		if(strpos($view, '/') !== false)
			throw new SleshPatchException();
		
		$patch = str_replace('.', '/', self::PATCH_VIEWS);
		
		$view = str_replace('.', '/', $view);
		
		$blade = new Blade('../'.$patch, '../storage/cache/Views');

		extract($data);
		echo $blade->make($view, $data)->render();
		
	}

    /**
     * Get Error register and delete error - получает массив ошибок и удаляет полсе обновление, или 1 ошибку
     *
     * @param   bool $first_mistake
     *
     * @return mixed
     */
	public function getErrorFlash($first_mistake = true)
	{
		
		if(Session::has(self::SESSION_NAME_ERROR))
		{
			if($first_mistake === true)
			{
				return array_shift(Session::flash(self::SESSION_NAME_ERROR));
			}
			
			return Session::flash(self::SESSION_NAME_ERROR);
		}
			
	}

    /**
     * Get Error register Array - получить массив ошибок, или получить массив ошибок 1
     *
     * @param   bool $first_mistake
     *
     * @return mixed
     */
	public function getError($first_mistake = true)
	{
		
		if(Session::has(self::SESSION_NAME_ERROR))
		{
			if($first_mistake === true)
			{
				return array_shift(Session::get(self::SESSION_NAME_ERROR));
			}
			
			return Session::get(self::SESSION_NAME_ERROR);
		}
		
	}
	
}