<?php

namespace App\Api\Payment;

class ExchangeRates
{
	
	/**
	 * Покупка валюты
	 *
     * @var array
     */
	private $currencyPurchase = [];
	
	/**
	 * Продажа валюты
	 *
     * @var array
     */
	private $saleCurrency = [];
	
	public function getBuy()
	{
		
		return $this->currencyPurchase;
		
	}
	
	public function getSale()
	{
		
		return $this->saleCurrency;
		
	}
	
}