<?php

namespace System\Validator\Validate;

use System\Validator\Validate\ArgumentsValidation;
use System\Validator\Validate\ValidationRules;

/**
 * Validator
 */
class Validator
{
        
    /**
     * validated
     *
     * @var bool
     */
    public $validated = false;
    
    /**
     * list
     *
     * @var array
     */
    private $list = [];
        
    /**
     * message
     *
     * @var string
     */
    private $message;
    
    /**
     * validation
     *
     * @var string
     */
    private $validation;
    
    /**
     * nameField
     *
     * @var string
     */
    private $nameField;
    
    /**
     * keyValidate
     *
     * @var mixed
     */
    private $keyValidate;
    
    /**
     * errors
     *
     * @var array
     */
    private $errors = [];
    
    /**
     * rules
     *
     * @var mixed
     */
    private $rules;

    /**
     * field
     *
     * @param  mixed $name
     * @param  mixed $value
     * @return void
     */
    public function field(string $name, $value = null)
    {

        $this->list[$name]['value'] = $value;

        return $this;

    }
    
    /**
     * with
     *
     * @param  mixed $name
     * @param  mixed $validation
     * @return void
     */
    public function with($name, $validation)
    {

        $this->nameField = $name;

        is_callable($validation) === true ? call_user_func_array($validation, [$this]) : $this->list[$name]['validation'][] = $validation;

        return $this;
        
    }
    
    /**
     * setMessage
     *
     * @param  mixed $message
     * @return void
     */
    public function setMessage(string $message)
    {

        $this->list[$this->nameField]['messages'][$this->keyValidate - 1] = $message;

        return $this;

    }
    
    /**
     * validation
     *
     * @param  mixed $validation
     * @return void
     */
    public function validation(string $validation)
    {

        $this->keyValidate = null;
        $this->list[$this->nameField]['validation'][] = $validation;
        $this->keyValidate = count($this->list[$this->nameField]['validation']);

        return $this;

    }
    
    /**
     * getError
     *
     * @return void
     */
    public function getError()
    {

        return array_shift($this->errors) ?? '';

    }
    
    /**
     * getErrors
     *
     * @return void
     */
    public function getErrors()
    {

        return $this->errors ?? [];

    }
    
    /**
     * getMessages
     *
     * @param  mixed $validateKey
     * @return void
     */
    private function getMessages(string $validateKey, string $element = 'messages')
    {

        $existsKeyValidate = array_key_exists($validateKey, $this->list) ?? false;

        if($existsKeyValidate === true)
        {
            $existsKeyMessage = array_key_exists($element, $this->list[$validateKey]) ?? false;

            return $existsKeyMessage === true ? $this->list[$validateKey][$element] : [];

        }
        
        return [];

    }
    
    /**
     * getValidation
     *
     * @param  mixed $validateKey
     * @return void
     */
    private function getValidation(string $validateKey)
    {

        return $this->getMessages($validateKey, 'validation');

    }
    
    /**
     * getAllKeyValidation
     *
     * @return void
     */
    private function getAllKeyValidation()
    {

        return array_keys($this->list) ?? [];

    }
    
    /**
     * handler
     *
     * @return void
     */
    private function handler()
    {

        $argumentsValidation = new ArgumentsValidation();
        $this->rules = new ValidationRules($this->list);

        foreach($this->getAllKeyValidation() as $nameField)
        {
            foreach($this->getValidation($nameField) as $keyRules => $valueRules)
            {

                $argument = $argumentsValidation->getArgument($valueRules);
                $splitArguments = $argumentsValidation->getMultipleArguments($valueRules);
                $arguments = $argumentsValidation->getSplitMuiltipleArguments($splitArguments);
                $rules = $argumentsValidation->getRules($valueRules);

                $this->commonHandler($this->list[$nameField]['value'], $argument, $arguments, $rules, $this->getMessages($nameField)[$keyRules], $nameField);

            }
        }

    }
    
    /**
     * commonHandler
     *
     * @param  mixed $value
     * @param  mixed $argument
     * @param  mixed $arguments
     * @param  mixed $rules
     * @param  mixed $message
     * @return void
     */
    private function commonHandler($value, $argument, $arguments, $rules, $message, $nameField)
    {

        $funcRules = $this->rules->$rules($value, $argument, $arguments, $message, $rules, $nameField);

        ($funcRules !== true) ? $this->errors[] = $funcRules : null;
        
    }
    
    /**
     * make
     *
     * @return void
     */
    public function make()
    {

        $this->handler();

        $this->validated = count($this->errors) > 0 ? false : true;

        return $this;

    }
    


}