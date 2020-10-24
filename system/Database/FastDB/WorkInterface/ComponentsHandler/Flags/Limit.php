<?php

namespace System\Database\FastDB\WorkInterface\ComponentsHandler\Flags;

/**
 * Where
 */
class Limit
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
     * @param  mixed $from
     * @param  mixed $before
     * @return void
     */
    public function handler(int $from, int $before)
    {

        $data = [];
        $newData = [];
        $allCount = count($this->selectedData);
        $from = ($from > $allCount) ? $allCount : $from;

        foreach($this->selectedData as $value)
        {
            $newData[] = $value;
        }

        if($before == -1) {
            for($i = 0; $i < $from; $i++) {
                $data[$i] = $newData[$i];
            }
        } else {
            $before = ($before <= ($from - 1)) ? count($this->selectedData) : $before;
            $before = ($before > count($this->selectedData)) ? count($this->selectedData) : $before;

            for($i = ($from - 1); $i < $before; $i++) {
                $data[$i] = $newData[$i];
            }
        }

        return $data;

    }

}