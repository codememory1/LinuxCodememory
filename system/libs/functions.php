<?php

/*
* ===_===_===_===_===_===_===_===_===_===_===_===_===_===_==
* ==========================================================
* Функция "debug" - эта функция служит для распечатывание 
* Массиво, в четабельном виде, 0 - print_r, 1 - var_dump
* ==========================================================
* ===_===_===_===_===_===_===_===_===_===_===_===_===_===_==
*/

function debug($value, $as = 0)
{

	echo "<pre>";
		if($as == 0)
		{
			print_r($value);
		}else if($as == 1)
		{
			var_dump($value);
		}   
	echo "</pre>";

}

/* Получение строки, обрезанной до заданного размера */
function get_line_size($str, $from, $before, $symbol = "")
{
	return mb_strimwidth($str, $from, $before, $symbol);
}

/* Возвращает ширину строки */
function width_line($str)
{
	return mb_strwidth($str);
}

/* Приведение строки к верхнему регистру */
function up_line($str)
{
	return mb_strtoupper($str);
}

/* Приведение строки к нижнему регистру */
function down_line($str)
{
	return mb_strtolower($str);
}

/* Приводит 1 символ строки вверхний регистр  */
function one_up_line($str)
{
	return ucfirst($str);
}

/* Приводит 1 символ строки в нижний регистр  */
function one_down_line($str)
{
	return lcfirst($str);
}

/* Конвертирует строку в нужную кодировку */
function conver_string_charset($str, $charset, $num3 = null)
{
	return mb_convert_encoding($str, $charset);
}

function error_log_tpl($file, $code, $line, $message)
{
	ob_start();
	
	$var = [
		'fine' 	  => $file,
		'code' 	  => $code,
		'line' 	  => $line,
		'message' => $message,
	];
	extract($var);
	
	$content = ob_get_contents();
	ob_end_clean();
	
	require '../resources/templates/error_log.php';
}