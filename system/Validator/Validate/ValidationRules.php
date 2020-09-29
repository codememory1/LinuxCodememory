<?php

namespace System\Validator\Validate;

use System\Validator\Validate\Interfaces\ErrorMessagesInterface;
use Db;

/**
 * ValidationRules
 */
class ValidationRules implements ErrorMessagesInterface
{
        
    /**
     * list
     *
     * @var array
     */
    private $list = [];
        
    /**
     * __construct
     *
     * @param  mixed $list
     * @return void
     */
    public function __construct(array $list)
    {

        $this->list = $list;

    }

    /**
     * getErrorMessage
     *
     * @param  mixed $message
     * @param  mixed $rules
     * @return void
     */
    private function getErrorMessage($message, $rules, array $replaces = [])
    {

        $constMessage = vsprintf(constant('self::'.strtoupper('ERR_'.$rules)), $replaces);

        return (is_null($message) === true) ? $constMessage : $message;

    }
    
    /** «»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«» 
     *                                  ПРАВИЛА ВАЛИДАЦИИ
     *  «»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»«»
    */

    /**
     * ----------------------------------------------------------------------
     * »»»» Максимальное кол-во символов в строке
     * ----------------------------------------------------------------------
     *
     * @param  mixed $value
     * @param  mixed $argument
     * @param  mixed $arguments
     * @param  mixed $message
     * @param  mixed $rules
     * @return void
     */
    public function max($value, string $argument, array $arguments, $message = null, string $rules, string $name)
    {

        if(iconv_strlen($value) > $argument)
        {
            return $this->getErrorMessage($message, $rules, [$name, $argument]);
        }

        return true;

    }
    
    /**
     * ----------------------------------------------------------------------
     * »»»» Минимальное кол-во символов в строке
     * ----------------------------------------------------------------------
     *
     * @param  mixed $value
     * @param  mixed $argument
     * @param  mixed $arguments
     * @param  mixed $message
     * @param  mixed $rules
     * @return void
     */
    public function min($value, string $argument, array $arguments, $message = null, string $rules, string $name)
    {

        if(iconv_strlen($value) < $argument)
        {
            return $this->getErrorMessage($message, $rules, [$name, $argument]);
        }

        return true;

    }
    
    /**
     * ----------------------------------------------------------------------
     * »»»» Минимальное / Максимальное кол-во символов
     * ----------------------------------------------------------------------
     *
     * @param  mixed $value
     * @param  mixed $argument
     * @param  mixed $arguments
     * @param  mixed $message
     * @param  mixed $rules
     * @return void
     */
    public function between($value, string $argument = null, array $arguments, $message = null, string $rules, string $name)
    {

        if(iconv_strlen($value) < $arguments[0] || iconv_strlen($value) > $arguments[1])
        {
            return $this->getErrorMessage($message, $rules, [$name, $arguments[0], $arguments[1]]);
        }

        return true;

    }
    
    /**
     * ----------------------------------------------------------------------
     * »»»» Проверка на число
     * ----------------------------------------------------------------------
     *
     * @param  mixed $value
     * @param  mixed $argument
     * @param  mixed $arguments
     * @param  mixed $message
     * @param  mixed $rules
     * @return void
     */
    public function numeric($value, string $argument = null, array $arguments, $message = null, string $rules, string $name)
    {

        if(is_numeric($value) === false)
        {
            return $this->getErrorMessage($message, $rules, [$name]);
        }

        return true;

    }
    
    /**
     * ----------------------------------------------------------------------
     * »»»» Проверка на диапазон чисел. Пример от 3 до 10
     * ----------------------------------------------------------------------
     *
     * @param  mixed $value
     * @param  mixed $argument
     * @param  mixed $arguments
     * @param  mixed $message
     * @param  mixed $rules
     * @param  mixed $name
     * @return void
     */
    public function range_numbers($value, string $argument = null, array $arguments, $message = null, string $rules, string $name)
    {

        if($value < $arguments[0] || $value > $arguments[1])
        {
            return $this->getErrorMessage($message, $rules, [$name, $arguments[0], $arguments[1]]);
        }

        return true;

    }
    
    /**
     * ----------------------------------------------------------------------
     * »»»» Проверка на целое число
     * ----------------------------------------------------------------------
     *
     * @param  mixed $value
     * @param  mixed $argument
     * @param  mixed $arguments
     * @param  mixed $message
     * @param  mixed $rules
     * @return void
     */
    public function integer($value, string $argument = null, array $arguments, $message = null, string $rules, string $name)
    {

        if(is_int($value) === false)
        {
            return $this->getErrorMessage($message, $rules, [$name]);
        }

        return true;

    }

    /**
     * ----------------------------------------------------------------------
     * »»»» Проверка на строку
     * ----------------------------------------------------------------------
     *
     * @param  mixed $value
     * @param  mixed $argument
     * @param  mixed $arguments
     * @param  mixed $message
     * @param  mixed $rules
     * @return void
     */
    public function string($value, string $argument = null, array $arguments, $message = null, string $rules, string $name)
    {

        if(is_string($value) === false)
        {
            return $this->getErrorMessage($message, $rules, [$name]);
        }

        return true;

    }
    
    /**
     * ----------------------------------------------------------------------
     * »»»» Проверка на Boolean
     * ----------------------------------------------------------------------
     *
     * @param  mixed $value
     * @param  mixed $argument
     * @param  mixed $arguments
     * @param  mixed $message
     * @param  mixed $rules
     * @return void
     */
    public function boolean($value, string $argument = null, array $arguments, $message = null, string $rules, string $name)
    {

        if($value !== true && $value !== false && $value != 1 && $value != 0 && $value != "1" && $value != "0")
        {
            return $this->getErrorMessage($message, $rules, [$name]);
        }

        return true;

    }
    
    /**
     * ----------------------------------------------------------------------
     * »»»» Проверка на дробное число
     * ----------------------------------------------------------------------
     *
     * @param  mixed $value
     * @param  mixed $argument
     * @param  mixed $arguments
     * @param  mixed $message
     * @param  mixed $rules
     * @return void
     */
    public function fractional($value, string $argument = null, array $arguments, $message = null, string $rules, string $name)
    {

        if(is_float($value) === false)
        {
            return $this->getErrorMessage($message, $rules, [$name]);
        }

        return true;

    }
    
    /**
     * ----------------------------------------------------------------------
     * »»»» Проверка на обязательность
     * ----------------------------------------------------------------------
     *
     * @param  mixed $value
     * @param  mixed $argument
     * @param  mixed $arguments
     * @param  mixed $message
     * @param  mixed $rules
     * @return void
     */
    public function required($value, string $argument = null, array $arguments, $message = null, string $rules, string $name)
    {

        if(empty($value))
        {
            return $this->getErrorMessage($message, $rules, [$name]);
        }

        return true;

    }
    
    /**
     * ----------------------------------------------------------------------
     * »»»» Проверка на обязательность, если заполены поля указаные в параметре
     * ----------------------------------------------------------------------
     *
     * @param  mixed $value
     * @param  mixed $argument
     * @param  mixed $arguments
     * @param  mixed $message
     * @param  mixed $rules
     * @param  mixed $name
     * @return void
     */
    public function required_if_filled($value, string $argument = null, array $arguments, $message = null, string $rules, string $name)
    {

        $numFilled = 0;
        foreach($arguments as $fields)
        {
            empty($this->list[$fields]['value']) === false ? $numFilled++ : null;
        }

        if($numFilled == count($arguments))
        {
            if(empty($value)) 
            {
                return $this->getErrorMessage($message, $rules, [$name, implode(',', $arguments)]);
            }
        }

        return true;

    }
    
    /**
     * ----------------------------------------------------------------------
     * »»»» Валидация Email
     * ----------------------------------------------------------------------
     *
     * @param  mixed $value
     * @param  mixed $argument
     * @param  mixed $arguments
     * @param  mixed $message
     * @param  mixed $rules
     * @return void
     */
    public function email($value, string $argument = null, array $arguments, $message = null, string $rules, string $name)
    {

        if(filter_var($value, FILTER_VALIDATE_EMAIL) === false)
        {
            return $this->getErrorMessage($message, $rules);
        }

        return true;

    }
    
    /**
     * ----------------------------------------------------------------------
     * »»»» Проверка на корректность даты
     * ----------------------------------------------------------------------
     *
     * @param  mixed $value
     * @param  mixed $argument
     * @param  mixed $arguments
     * @param  mixed $message
     * @param  mixed $rules
     * @return void
     */
    public function date($value, string $argument = null, array $arguments, $message = null, string $rules, string $name)
    {
        
        if(is_numeric(strtotime($value)) === false)
        {
            return $this->getErrorMessage($message, $rules);
        }

        return true;

    }
    
    /**
     * ----------------------------------------------------------------------
     * »»»» Проверка на Json
     * ----------------------------------------------------------------------
     *
     * @param  mixed $value
     * @param  mixed $argument
     * @param  mixed $arguments
     * @param  mixed $message
     * @param  mixed $rules
     * @return void
     */
    public function json($value, string $argument = null, array $arguments, $message = null, string $rules, string $name)
    {

        if(is_string($value) === false || is_array(json_decode($value, true)) === false)
        {
            return $this->getErrorMessage($message, $rules);
        }

        return true;

    }
    
    /**
     * ----------------------------------------------------------------------
     * »»»» Проверка на корректность Ip
     * ----------------------------------------------------------------------
     *
     * @param  mixed $value
     * @param  mixed $argument
     * @param  mixed $arguments
     * @param  mixed $message
     * @param  mixed $rules
     * @return void
     */
    public function ip($value, string $argument = null, array $arguments, $message = null, string $rules, string $name)
    {

        if(filter_var($value, FILTER_VALIDATE_IP) === false)
        {
            return $this->getErrorMessage($message, $rules);
        }

        return true;

    }
    
    /**
     * ----------------------------------------------------------------------
     * »»»» Проверка на корректность Ip сервера FastDB
     * ----------------------------------------------------------------------
     *
     * @param  mixed $value
     * @param  mixed $argument
     * @param  mixed $arguments
     * @param  mixed $message
     * @param  mixed $rules
     * @param  mixed $name
     * @return void
     */
    public function fastdb_server($value, string $argument = null, array $arguments, $message = null, string $rules, string $name)
    {

        if(preg_match('/^[\d+]{3}\.[\d+]{3}\.[\d+]{2}\.[\d+]{2}\.[\d+]{1}(\:|\-)[\d+]{4}$/', $value) === 0)
        {
            return $this->getErrorMessage($message, $rules);
        }

        return true;

    }

    /**
     * ----------------------------------------------------------------------
     * »»»» Проверка на корректность Url-адреса
     * ----------------------------------------------------------------------
     *
     * @param  mixed $value
     * @param  mixed $argument
     * @param  mixed $arguments
     * @param  mixed $message
     * @param  mixed $rules
     * @param  mixed $name
     * @return void
     */
    public function url($value, string $argument, array $arguments, $message = null, string $rules, string $name)
    {

        $imagePatter = '/^(http|https)\:\/\/(?:www\.)?(.*)\.(.*)\/(.*)\.(raw|jpeg|jpg|tiff|psd|bmp|gif|png|jp2)$/';
        $defaultPattern = '/^(http|https)\:\/\/(?:www\.)?(.*)\.(.*)$/';
        $pattern = ($argument == 'image') ? $imagePatter : $defaultPattern;

        if(preg_match($pattern, $value) === 0)
        {
            return $this->getErrorMessage($message, $rules);
        }
       
        return true;

    }
    
    /**
     * ----------------------------------------------------------------------
     * »»»» Проверка по Regex
     * ----------------------------------------------------------------------
     *
     * @param  mixed $value
     * @param  mixed $argument
     * @param  mixed $arguments
     * @param  mixed $message
     * @param  mixed $rules
     * @return void
     */
    public function regular($value, string $argument, array $arguments, $message = null, string $rules, string $name)
    {

        if(preg_match($argument, $value) === 0)
        {
            return $this->getErrorMessage($message, $rules, [$name, $argument]);
        }

        return true;

    }
    
    /**
     * ----------------------------------------------------------------------
     * »»»» Не должно совподать с Regex
     * ----------------------------------------------------------------------
     *
     * @param  mixed $value
     * @param  mixed $argument
     * @param  mixed $arguments
     * @param  mixed $message
     * @param  mixed $rules
     * @param  mixed $name
     * @return void
     */
    public function not_regular($value, string $argument, array $arguments, $message = null, string $rules, string $name)
    {

        if(preg_match($argument, $value) === 1)
        {
            return $this->getErrorMessage($message, $rules, [$name, $argument]);
        }

        return true;

    }
    
    /**
     * ----------------------------------------------------------------------
     * »»»» Проверка на содержимое, одно и друго элемента. Пример pass,pass2
     * ----------------------------------------------------------------------
     * @param  mixed $value
     * @param  mixed $argument
     * @param  mixed $arguments
     * @param  mixed $message
     * @param  mixed $rules
     * @return void
     */
    public function same($value, string $argument, array $arguments, $message = null, string $rules, string $name)
    {

        if($this->list[$arguments[0]]['value'] != $this->list[$arguments[1]]['value']) 
        {
            return $this->getErrorMessage($message, $rules, [$name, $argument]);
        }

        return true;

    }
    
    /**
     * ----------------------------------------------------------------------
     * »»»» Должно содержать только символы. Пример only:red,blue,orange
     * ----------------------------------------------------------------------
     *
     * @param  mixed $value
     * @param  mixed $argument
     * @param  mixed $arguments
     * @param  mixed $message
     * @param  mixed $rules
     * @return void
     */
    public function only($value, string $argument, array $arguments, $message = null, string $rules, string $name)
    {

        if(in_array($value, $arguments) !== true) 
        {
            return $this->getErrorMessage($message, $rules, [$name, implode(',', $arguments)]);
        }

        return true;

    }

    /**
     * ----------------------------------------------------------------------
     * »»»» Не Должно содержать. Пример not_only:red,blue,orange
     * ----------------------------------------------------------------------
     *
     * @param  mixed $value
     * @param  mixed $argument
     * @param  mixed $arguments
     * @param  mixed $message
     * @param  mixed $rules
     * @return void
     */
    public function not_only($value, string $argument, array $arguments, $message = null, string $rules, string $name)
    {

        if(in_array($value, $arguments) === true) {
            return $this->getErrorMessage($message, $rules, [$name, implode(',', $arguments)]);
        }

        return true;

    }
    
    /**
     * ----------------------------------------------------------------------
     * »»»» Проверка на латинские буквы
     * ----------------------------------------------------------------------
     *
     * @param  mixed $value
     * @param  mixed $argument
     * @param  mixed $arguments
     * @param  mixed $message
     * @param  mixed $rules
     * @return void
     */
    public function alpha($value, string $argument = null, array $arguments, $message = null, string $rules, string $name)
    {

        if(preg_match('/^[a-z]+$/i', $value) === 0) 
        {
            return $this->getErrorMessage($message, $rules, [$name]);
        }

        return true;

    }
    
    /**
     * ----------------------------------------------------------------------
     * »»»» Проверка на латинские буквы и цифры
     * ----------------------------------------------------------------------
     *
     * @param  mixed $value
     * @param  mixed $argument
     * @param  mixed $arguments
     * @param  mixed $message
     * @param  mixed $rules
     * @param  mixed $name
     * @return void
     */
    public function alpha_num($value, string $argument = null, array $arguments, $message = null, string $rules, string $name)
    {

        if(preg_match('/^[a-z0-9]+$/i', $value) === 0) 
        {
            return $this->getErrorMessage($message, $rules, [$name]);
        }

        return true;

    }
    
    /**
     * ----------------------------------------------------------------------
     * »»»» Проверка на латинские буквы и цифры + символы -,_,=
     * ----------------------------------------------------------------------
     *
     * @param  mixed $value
     * @param  mixed $argument
     * @param  mixed $arguments
     * @param  mixed $message
     * @param  mixed $rules
     * @param  mixed $name
     * @return void
     */
    public function alpha_dash($value, string $argument = null, array $arguments, $message = null, string $rules, string $name)
    {

        if(preg_match('/^[a-z0-9\_\-\=]+$/i', $value) === 0) 
        {
            return $this->getErrorMessage($message, $rules, [$name]);
        }

        return true;

    }
    
    /**
     * ----------------------------------------------------------------------
     * »»»» Проверка на уникальность в БД
     * ----------------------------------------------------------------------
     *
     * @param  mixed $value
     * @param  mixed $argument
     * @param  mixed $arguments
     * @param  mixed $message
     * @param  mixed $rules
     * @param  mixed $name
     * @return void
     */
    public function unique($value, string $argument = null, array $arguments, $message = null, string $rules, string $name)
    {

        $inquiry = Db::findLike($arguments[0], [$arguments[1] => $value]);

        if(count($inquiry) > 0)
        {
            return $this->getErrorMessage($message, $rules, [$value]);
        }

        return true;

    }

}