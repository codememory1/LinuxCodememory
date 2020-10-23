<?php

namespace System\Database\FastDB\WorkInterface\ComponentsHandler\Flags;

/**
 * Where
 */
class Where
{
    
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
    public function handler(string $column, string $separator, string $separatorMethod, $value)
    {

        $result = [];

        foreach($this->selectedData as $key => $data)
        {

            $perk = $this->$separatorMethod($column, $value, $data, $key);
            
            if($perk !== []) {
                $result[$key] = $this->$separatorMethod($column, $value, $data, $key);
            }

        }

        return $result;

    }
    
    /**
     * equal
     *
     * @param  string $column
     * @param  mixed $value
     * @param  array $data
     * @param  int $key
     * @return void
     */
    private function equal(string $column, $value, array $data, int $key):array
    {

        if($data[$column] == $value) {
            return $this->selectedData[$key];
        }
        
        return [];
        
    }
    
    /**
     * notEqual
     *
     * @param  string $column
     * @param  mixed $value
     * @param  array $data
     * @param  int $key
     * @return void
     */
    private function notEqual(string $column, $value, array $data, int $key):array
    {

        if($data[$column] != $value) {
            return $this->selectedData[$key];
        }

        return [];

    }
    
    /**
     * more
     *
     * @param  mixed $column
     * @param  mixed $value
     * @param  mixed $data
     * @param  mixed $key
     * @return void
     */
    private function more(string $column, $value, array $data, int $key):array
    {

        if($data[$column] > $value) {
            return $this->selectedData[$key];
        }

        return [];

    }
    
    /**
     * less
     *
     * @param  mixed $column
     * @param  mixed $value
     * @param  mixed $data
     * @param  mixed $key
     * @return void
     */
    private function less(string $column, $value, array $data, int $key):array
    {

        if($data[$column] < $value) {
            return $this->selectedData[$key];
        }

        return [];

    }
    
    /**
     * moreEquals
     *
     * @param  mixed $column
     * @param  mixed $value
     * @param  mixed $data
     * @param  mixed $key
     * @return void
     */
    private function moreEquals(string $column, $value, array $data, int $key):array
    {

        if($data[$column] >= $value) {
            return $this->selectedData[$key];
        }

        return [];

    }
    
    /**
     * lessEquals
     *
     * @param  mixed $column
     * @param  mixed $value
     * @param  mixed $data
     * @param  mixed $key
     * @return void
     */
    private function lessEquals(string $column, $value, array $data, int $key):array
    {

        if($data[$column] <= $value) {
            return $this->selectedData[$key];
        }

        return [];

    }
    
    /**
     * lessMore
     *
     * @param  mixed $column
     * @param  mixed $value
     * @param  mixed $data
     * @param  mixed $key
     * @return void
     */
    private function lessMore(string $column, $value, array $data, int $key):array
    {

        if($data[$column] <> $value) {
            return $this->selectedData[$key];
        }

        return [];

    }

}