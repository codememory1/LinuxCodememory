<?php

namespace App\Api\Payment\Configurations;

trait BasicSettingsTrait
{
	
	/**
	 * Минимальная сумма
	 *
     * @var int
     */
	private $minAmount = 5;
	
	/**
	 * Максимальная сумма
	 *
     * @var int
     */
	private $maxAmount = 100000;
	
	/**
	 * Валюта по умолчанию, если валюта не выбрана
	 *
     * @var string
     */
	private $defaultCurrency = 'RUB';
	
	/**
	 * Список валют
	 *
     * @var array
     */
	private $currencies = [ 'RUB', 'USD', 'UAH' ];
	
	/**
	 * Иконки валют font awesome
	 *
     * @var array
     */
	private $iconsCurrency = [
		'RUB' => 'fa-ruble-sign',
		'USD' => 'fa-dollar-sign',
		'UAH' => 'fa-hryvnia',
	];
	
	/**
	 * Время оплаты - в минутах
	 *
     * @var int
     */
	private $paymentTime = 10;
	
	/**
	 * Описание оплаты, по умолчанию
	 *
     * @var int
     */
	private $description = 'Оплата заказа';
	
}