<?php

namespace System\Authentication;

use System\Authentication\Interfaces\CommonInterface;
use Request;
use System\Validator\Validate\Validator;
use System\Authentication\AuthHandler;

/**
 * Class Authorization
 * @package System\Authentication
 */
class Authorization implements CommonInterface
{
		
	/**
	 * dataFrom
	 *
	 * @var string
	 */
	private $dataFrom = 'db';
	
	/**
	 * requestData
	 *
	 * @var array
	 */
	private $requestData = [];
	
	/**
	 * handledData
	 *
	 * @var array
	 */
	private $generatedData = [];
	
	/**
	 * localUsers
	 *
	 * @var array
	 */
	private $localUsers = [];
	
	/**
	 * table
	 *
	 * @var undefined
	 */
	private $table = null;
	
	/**
	 * validation
	 *
	 * @var array
	 */
	private $validation = [];
	
	/**
	 * validationMessages
	 *
	 * @var array
	 */
	private $validationMessages = [];
	
	/**
	 * searches
	 *
	 * @var array
	 */
	private $searches = [];
	
	/**
	 * $numberValidation - Ключ массива валидации
	 * $message - сообщение, если валидация провалина
	 * 
	 * setMessageValidation
	 *
	 * @param  mixed $numberValidation
	 * @param  mixed $message
	 * @return void
	 */
	public function setMessageValidation(int $numberValidation, string $message)
	{

		$this->validationMessages[$numberValidation] = $message;

		return $this;

	}
	
	/**
	 * Метод индентичен setMessageValidation() только тут просто массив сообщений
	 * 
	 * setMessageValidationArray
	 *
	 * @param  mixed $message
	 * @return void
	 */
	public function setMessageValidationArray(array $message)
	{

		$this->validationMessages = $message;

		return $this;

	}
	
	/**
	 * $field - имя поля input который обрабатывается
	 * $rules - массив правил для валидации
	 * $callback - каллбак в котором записуются сообщения, если валидация провалена. Принимает аргумент: $this - обЪект данного класса
	 * $required - обязателность к заполнению, валидация сработает, если поле будет заполнено
	 * 
	 * setValidation
	 *
	 * @param  mixed $field
	 * @param  mixed $rules
	 * @param  mixed $callback
	 * @param  mixed $required
	 * @return void
	 */
	public function setValidation(string $field, array $rules, callable $callback, bool $required = true)
	{

		$this->validationMessages = [];

		call_user_func_array($callback, [$this]);

		$this->validation[$field] = [
			'rules'    => $rules,
			'messages' => $this->validationMessages,
			'required' => $required
		];

		return $this;

	}
		
	/**
	 * $fieldsDb - массив ключей из бд, или массива по которым будет осуществляться поиск пользователя
	 * $comparisonData - массив введеных данных по которым будет осуществляться поиск пользователя
	 * 
	 * searchUser
	 *
	 * @param  mixed $fieldsDb
	 * @param  mixed $comparisonData
	 * @return void
	 */
	public function searchUser(array $fieldsDb, array $comparisonData)
	{

		$this->searches['fields'] = $fieldsDb;
		$this->searches['comparison'] = $comparisonData;

		return $this;

	}

	/**
	 * $dataFrom - db|array где искать пользователя в бд, или в массиве, если array то доолжен быть заполнен аргумент $users
	 * $requestData - request данных авторизации
	 * $table - название таблицы в бд mysql
	 * $users - список пользователей, по которым будет осуществляться поиск. Example: [ ['login' => 123, 'password' => 123], ... ]
	 * 
	 * configuration
	 *
	 * @param  mixed $dataFrom
	 * @param  mixed $requestData
	 * @param  mixed $table
	 * @return void
	 */
	public function configuration(string $dataFrom, array $requestData, string $table = null, array $users = [])
	{

		$regexDataFrom = preg_match('/^(db|array)$/', $dataFrom);
		$this->dataFrom = $regexDataFrom === 1 ? $dataFrom : $this->dataFrom;

		$this->requestData = $requestData;
		$this->table = $table;
		$this->localUsers = $users;

		return $this;

	}
	
	/**
	 * renderRequestData
	 *
	 * @return void
	 */
	private function generateRequestData()
	{

		$request = $this->requestData;
		$validation = $this->validation;

		$data = [];

		foreach($validation as $field => $validate)
		{
			if(array_key_exists($field, $request) === true)
			{
				$data[$field] = [
					'rules'    => $validate['rules'],
					'messages' => $validate['messages'],
					'data'	   => $request[$field],
					'required' => $validate['required']
				];
			}
		}

		$this->generatedData = $data;

		return true;

	}
	
	/**
	 * __call
	 *
	 * @param  mixed $method
	 * @param  mixed $arguments
	 * @return void
	 */
	public function __call($method, $arguments)
	{

		$this->generateRequestData();

		$auth = new AuthHandler($this->generatedData, $this->table, $this->dataFrom, $this->localUsers, $this->searches);

		return call_user_func_array([$auth, $method], $arguments);

	}
    
}