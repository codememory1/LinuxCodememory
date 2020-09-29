<?php

namespace System\Authentication;

use Db;
use Validator;

/**
 * Class AuthHandle
 * @package System\Authentication
 */
class RegistrationHandle
{

    /**
     * @var object
     */
	private $request;

    /**
     * @var array
     */
	private $unique = [];

    /**
     * @var string
     */
	private $table;

    /**
     * RegistrationHandle constructor.
     *
     * @param $table
     */
    public function __construct($table)
	{
		
		$this->table = $table;
		
	}

    /**
     * Check Unique data in Db - проверяет данные на уникальность с данными в бд
     *
     * @param   array $unique
     *
     * @return mixed
     */
	public function checkUnique(array $unique = [])
	{
		
		$this->unique = $unique;
		
		$requestValue = [];
		$rulesValidate = [];
		
		$ruleString = 'unique:'.$this->table.',';
		$ruleMessage = 'Пользователь с таким %s уже существует.';
		
		if(count($this->unique) > 0)
		{
			foreach($this->unique as $keyNum => $requestName)
			{
				$requestValue[$requestName] = \Request::post($requestName)->give();
				$rulesValidate[$requestName] = 'unique:'.$this->table.','.$requestName.'('.sprintf($ruleMessage, $requestName).')';
			}
			
			$uniqueValidate = Validator::make($requestValue, $rulesValidate);
			
			return $uniqueValidate;
			
		}
		
	}

    /**
     * Add User in Db - создает пользователя в БД
     *
     * @param   array $kyes
     * @param   array $values
     */
	public function create(array $kyes, array $values)
	{
		
		Db::insert()
			->into($this->table)
			->columns($kyes)
			->values($values)
			->execute();
		
	}
	
}