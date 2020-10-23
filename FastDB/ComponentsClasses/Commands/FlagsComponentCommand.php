<?php

namespace FastDB\ComponentsClasses\Commands;

use FastDB\ComponentsClasses\Commands\Exceptions\FlagNotFoundException;

/**
 * FlagsComponentCommand
 * @package FastDB\Commands
 */
class FlagsComponentCommand
{
    
    /**
     * data
     *
     * @var mixed
     */
    private $data;
    
    /**
     * operators
     *
     * @var array
     */
    private $operators = [
		'=', '!=', '>', '<', '>=', '<=', '<>'
	];
    
    /**
     * __construct
     *
     * @param  mixed $data
     * @return void
     */
    public function __construct($data)
    {

        $this->data = $data;

    }
    
    /**
     * getOperatorsString
     *
     * @param  mixed $separator
     * @return void
     */
    private function getOperatorsString(string $separator = '|')
    {

        $operators = null;

        foreach($this->operators as $key => $operator)
        {
            $operators .= array_key_last($this->operators) === $key ? 
                '\\'.$operator : 
            '\\'.$operator.$separator;
        }

        return $operators;

    }
    
    /**
     * execute
     *
     * @param  mixed $flags
     * @return void
     */
    public function execute(string $flags)
    {

        $data = $this->data;
        $regexFlag = '/(?<name>[A-Z\-]+)\((?<value>.*)\)/U';
        $matchRegex = preg_match_all($regexFlag, $flags, $matches);

        foreach($matches as $k => $v) if(is_numeric($k)) unset($matches[$k]);

        foreach($matches['name'] as $numFlag => $nameFlag)
        {
            $flag = down_line($nameFlag);
            $nameFlag = preg_replace('/\-([a-z]{1})/i', '$1', down_line($nameFlag));

            if(method_exists($this, $nameFlag) === false) throw new FlagNotFoundException(debug_backtrace(), $flag);

            $data = $this->$nameFlag($flag, $matches['value'][$numFlag], $data);
        }

        return $data;

    }
        
    /**
     * condition
     *
     * @param  mixed $name
     * @param  mixed $value
     * @param  mixed $data
     * @param  mixed $method
     * @return void
     */
    private function condition(string $name, $value, $data, string $method)
    {

        $matchValue = '/\`(?<keys>.*)\`\s+\`(?<values>.*)\`(?:\s+(?<flags>[a-zA-Z]+))?/';
        preg_match_all($matchValue, $value, $matches);

        foreach($matches as $k => $v) if(is_numeric($k)) unset($matches[$k]);

        foreach($matches['keys'] as $k => $value)
        {
            $data = call_user_func_array([$data, $method], [$value, $matches['values'][$k], $matches['flags'][$k]]);
        }

        return $data;

    }

    /**
     * if
     *
     * @param  mixed $name
     * @param  mixed $value
     * @param  mixed $data
     * @return void
     */
    private function if(string $name, $value, $data)
    {

        return $this->condition($name, $value, $data, 'conditionIf');

    }
    
    /**
     * notif
     *
     * @param  mixed $name
     * @param  mixed $value
     * @param  mixed $data
     * @return void
     */
    private function notif(string $name, $value, $data)
    {

        return $this->condition($name, $value, $data, 'conditionNotIf');

    }
    
    /**
     * sort
     *
     * @param  mixed $name
     * @param  mixed $value
     * @param  mixed $data
     * @return void
     */
    private function sortbynumbers(string $name, $value, $data)
    {

        $matchValue = '/\`(?<keys>.*)\`(?:\s+)?\=(?:\s+)\`(?<values>.*)\`/U';
        preg_match_all($matchValue, $value, $matches);

        foreach($matches as $k => $v) if(is_numeric($k)) unset($matches[$k]);

        foreach($matches['keys'] as $k => $value)
        {
            $data = $data->sortByNumbers($value, down_line($matches['values'][$k]));
        }

        return $data;

    }
    
    /**
     * where
     *
     * @param  mixed $name
     * @param  mixed $value
     * @param  mixed $data
     * @return void
     */
    private function where(string $name, $value, $data)
    {
        
        $matchValue = '/\`(?<keys>.*)\`(?:\s+)?(?<operators>'.$this->getOperatorsString().')(?:\s+)?\`(?<values>.*)\`/U';
        
        preg_match_all($matchValue, $value, $matches);

        foreach($matches as $k => $v) if(is_numeric($k)) unset($matches[$k]);

        foreach($matches['keys'] as $k => $value)
        {
            $data = $data->where($value, $matches['operators'][$k], $matches['values'][$k]);
        }

        return $data;
        
    }
    
    /**
     * limit
     *
     * @param  mixed $name
     * @param  mixed $value
     * @param  mixed $data
     * @return void
     */
    private function limit(string $name, $value, $data)
    {

        $seperatorValue = explode(',', $value);
		
		$from = (array_key_exists(0, $seperatorValue)) ? $seperatorValue[0] : 1;
		$before = (array_key_exists(1, $seperatorValue)) ? $seperatorValue[1] : -1;
	
		return $data->limit(trim($from), trim($before));

    }

}