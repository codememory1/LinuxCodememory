<?php

namespace System\Database\FastDB;

/**
 * Class HandleExecutionWhere
 * @package System\Database\FastDB
 */
class HandleExecutionWhere
{

    /**
     * @var array
     */
    private $data = [];

    /**
     * @var string
     */
	private $field;

    /**
     * @var string
     */
	private $as;

    /**
     * @var string
     */
	private $value;

    /**
     * HandleExecutionWhere constructor.
     *
     * @param   array $data
     * @param $field
     * @param $as
     * @param $value
     */
	public function __construct(array $data, $field, $as, $value)
	{
		
		$this->data = $data;
		$this->field = $field;
		$this->as = $as;
		$this->value = $value;
		
	}

    /**
     * Метод который получает записи таблицы
     *
     * @return array
     */
	public function getData()
	{
		
		return $this->data;
		
	}

    /**
     * @param   string $asMethod
     *
     * @return $this
     */
	public function handle(string $asMethod)
	{
		
		$data = [];
		
		foreach($this->data as $key => $value)
		{
			
			$data += $this->$asMethod($value, $this->field, $this->value, $key);
			
		}
		
		$this->data = $data;
		
		return $this;
		
	}

    /**
     * @param   array $value
     * @param $field
     * @param $valueKey
     * @param $key
     *
     * @return array
     */
	private function whereEqually(array $value, $field, $valueKey, $key)
	{
		
		$data = [];
		
		if($value[$field] == $valueKey)
		{
			$data[$key] = $this->data[$key];
		}

		return $data;
		
	}

    /**
     * @param   array $value
     * @param $field
     * @param $valueKey
     * @param $key
     *
     * @return array
     */
	private function whereNotEqual(array $value, $field, $valueKey, $key)
	{
		
		$data = [];
		
		if($value[$field] != $valueKey)
		{
			$data[$key] = $this->data[$key];
		}

		return $data;
		
	}

    /**
     * @param   array $value
     * @param $field
     * @param $valueKey
     * @param $key
     *
     * @return array
     */
	private function whereMore(array $value, $field, $valueKey, $key)
	{
		
		$data = [];
		
		if($value[$field] > $valueKey)
		{
			$data[$key] = $this->data[$key];
		}

		return $data;
		
	}

    /**
     * @param   array $value
     * @param $field
     * @param $valueKey
     * @param $key
     *
     * @return array
     */
	private function whereLess(array $value, $field, $valueKey, $key)
	{
		
		$data = [];
		
		if($value[$field] < $valueKey)
		{
			$data[$key] = $this->data[$key];
		}

		return $data;
		
	}

    /**
     * @param   array $value
     * @param $field
     * @param $valueKey
     * @param $key
     *
     * @return array
     */
	private function whereMoreEqual(array $value, $field, $valueKey, $key)
	{
		
		$data = [];
		
		if($value[$field] >= $valueKey)
		{
			$data[$key] = $this->data[$key];
		}

		return $data;
		
	}

    /**
     * @param   array $value
     * @param $field
     * @param $valueKey
     * @param $key
     *
     * @return array
     */
	private function whereLessEqual(array $value, $field, $valueKey, $key)
	{
		
		$data = [];
		
		if($value[$field] <= $valueKey)
		{
			$data[$key] = $this->data[$key];
		}

		return $data;
		
	}

    /**
     * @param   array $value
     * @param $field
     * @param $valueKey
     * @param $key
     *
     * @return array
     */
	private function whereLessMore(array $value, $field, $valueKey, $key)
	{
		
		$data = [];
		
		if($value[$field] < $valueKey || $value[$field] > $valueKey)
		{
			$data[$key] = $this->data[$key];
		}

		return $data;
		
	}
    
}