<?php

namespace App\Api\Payment;

use App\Api\Payment\Configurations\BasicSettingsTrait;
use Jenssegers\Blade\Blade;
use System\Exceptions\SleshPatchException;
use System\Codememory\AbstractComponent\View;
use Request;
use Session;

class Payment
{
	
	use BasicSettingsTrait;
	
	const PATCH_VIEW_PAYMENT = '/app/Api/Payment/Views';
	
	const ERRORS_CODE = [
		
		// User Error Code
		100 => 'Not authorized.',
		101 => 'Api for this account is denied.',
		102 => 'Critical error. Try later.',
		103 => 'Invalid user api key.',
		
		// System Error Code
		200 => 'The indicated amount is less than the minimum.',
		201 => 'The indicated sum is greater than the maximum.',
		202 => 'Invalid currency.',
		203 => 'Invalid request token.',
		
		// Server Error Code
		300 => 'Server error.'
		
	];
	
	private $errors = [];
	
	private $data = [];
	
	private function checkAuth()
	{
		
		return Session::has('CDM_AUTH') ?? false;
		
	}
	
	public function data()
	{
		
		
		$this->data = [
			'amount' 	  	=> (!empty(Request::post('amount')->give())) ? Request::post('amount')->give() : 0,
			'description' 	=> (!empty(Request::post('desc')->give())) ? Request::post('desc')->give() : $this->description ,
			'currency' 	  	=> (!empty(Request::post('cc')->give())) ? Request::post('cc')->give() : $this->defaultCurrency,
			'email'         => Request::post('email')->give(),
			'currency_icon' => $this->iconsCurrency
		];
		
		return $this;
		
	}
	
	public function getData($name = null)
	{
		
		return $this->data;
		
	}
	
	public function getErrors():array
	{
		
		return $this->errors;
		
	}
	
	public function getError():array
	{
		
		$keys = array_keys($this->errors);
		
		$error = (count($this->errors) > 0) ? 
			[array_shift($keys) => array_shift($this->errors)] : 
		[];
		
		return $error;
		
	}
	
	public function handleError()
	{
		
		$currency = array_combine($this->currencies, $this->currencies);
		
		($this->checkAuth() === false) ? 
			$this->errors[100] = static::ERRORS_CODE[100] : // Проверка на авторизацию
		null;
		
		($this->data['amount'] < $this->minAmount) ? 
			$this->errors[200] = static::ERRORS_CODE[200] : // Проверка на минимальную сумму
		null;
		($this->data['amount'] > $this->maxAmount) ? 
			$this->errors[201] = static::ERRORS_CODE[201] : // Проверка на максимальную сумму
		null;
		(!array_key_exists(up_line($this->data['currency']), $currency)) ? 
			$this->errors[202] = static::ERRORS_CODE[202] : // Проверка корректность валюты
		null;
		
		return $this;
	}
	
	public function viewPayment($view, $data = [])
	{

		$blade = new Blade('../app/Api/Payment/Views', '../storage/cache/Views');

		echo $blade->make($view, $data)->render();
		
	}
	
}