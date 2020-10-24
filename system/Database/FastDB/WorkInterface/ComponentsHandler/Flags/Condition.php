<?php

namespace System\Database\FastDB\WorkInterface\ComponentsHandler\Flags;

/**
 * Where
 */
class Condition
{
        
    /**
     * regexs
     *
     * @var array
     */
    protected $regexs = [
        '*%s' => '/^%s.*/',
        '%s!' => '/.*%s$/'
    ];

    /**
     * selectedData
     *
     * @var array
     */
    protected $selectedData = [];
    
    /**
     * __construct
     *
     * @param  mixed $data
     * @return void
     */
    public function __construct(array $data)
    {
        
        $this->selectedData = $data;

    }
    
    /**
     * handler
     *
     * @param  mixed $column
     * @param  mixed $separator
     * @param  mixed $value
     * @return void
     */
    public function handler(string $column, string $regex, ?string $flags = null, string $condition)
    {

        $method = 'condition'.one_up_line($condition);

        return $this->$method($column, $regex, $flags);

    }
        
    /**
     * conditionIf
     *
     * @param  mixed $column
     * @param  mixed $regex
     * @return void
     */
    private function conditionIf(string $column, string $regex, ?string $flags = null)
    {

        $data = [];

        foreach($this->selectedData as $k => $value)
        {
            if(preg_match('/'.$regex.'/'.$flags, $value[$column])) {
                $data[$k] = $value;
            }
        }

        return $data;

    }
    
    /**
     * conditionNotIf
     *
     * @param  mixed $column
     * @param  mixed $regex
     * @param  mixed $flags
     * @return void
     */
    private function conditionNotIf(string $column, string $regex, ?string $flags = null)
    {

        $data = [];

        foreach($this->selectedData as $k => $value)
        {
            if(!preg_match('/'.$regex.'/'.$flags, $value[$column])) {
                $data[$k] = $value;
            }
        }

        return $data;

    }
}