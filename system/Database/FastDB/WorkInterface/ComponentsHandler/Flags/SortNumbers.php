<?php

namespace System\Database\FastDB\WorkInterface\ComponentsHandler\Flags;

/**
 * Where
 */
class SortNumbers
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
    public function handler(string $column, string $as)
    {

        usort($this->selectedData, function($a, $b) use ($column, $as) {

            $more = function() use ($column, $a, $b){
                if($b[$column] > $a[$column]) {
                    return $a;
                }
            };
            $less = function() use ($column, $a, $b){
                if($b[$column] < $a[$column]) {
                    return $b;
                }
            };

            switch($as) {
                case 'more':
                    return $more();
                break;
                case 'less':
                    return $less();
                break;
            }
        });

        return $this->selectedData;

    }

}