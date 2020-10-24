<?php

namespace System\Validator\Validate;

use System\Validator\Validate\Interfaces\SectionValidationInterface as SectionValidation;

/**
 * ArgumentsValidation
 */
class ArgumentsValidation implements SectionValidation
{
        
    /**
     * getArgument
     *
     * @param  mixed $regex
     * @return void
     */
    public function getArgument(string $argumentRules)
    {

        preg_match_all(self::ARGUMENT, $argumentRules, $matches);

        return $matches[2][0];

    }
    
    /**
     * getMultipleArguments
     *
     * @param  mixed $regex
     * @return void
     */
    public function getMultipleArguments(string $argumentRules)
    {

        $arguments = preg_match_all(self::MULTIPLE_ARGUMENTS, $argumentRules, $matches);

        return $matches[2][0] ?? '';

    }
    
    /**
     * splitArgumentsMap
     *
     * @param  mixed $argument
     * @return void
     */
    private function splitArgumentsMap(string $argument)
    {

        return trim($argument);

    }
    
    /**
     * getSplitMuiltipleArguments
     *
     * @param  mixed $params
     * @return void
     */
    public function getSplitMuiltipleArguments(string $params)
    {

        $arguments = explode(',', $params);
        $mapArguments = array_map([$this, 'splitArgumentsMap'], $arguments);

        $newArgumentsArray = [];

        foreach($mapArguments as $kArgument => $argument)
        {
            $valueArguments = preg_match(self::VALUE_MULTIPLE_ARGUMENT, $argument, $matches);

            if($valueArguments === 1) 
            {
                $newArgumentsArray[] = $matches[1];
                $newArgumentsArray['value'][$kArgument] = $matches[2];
            }
            else {
                $newArgumentsArray[] = $argument;
            }

        }

        return $newArgumentsArray ?? [];

    }
    
    /**
     * getRules
     *
     * @param  mixed $fullRules
     * @return void
     */
    public function getRules(string $fullRules)
    {

        list($rules, $argument) = explode(':', $fullRules, 2);

        return $rules;

    }

}