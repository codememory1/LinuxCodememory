<?php

namespace FastDB\ComponentsClasses;

use Validator;

/**
 * ComponentTypes
 */
class ComponentTypes
{
        
    /**
     * server
     *
     * @var mixed
     */
    private $server; 

    /**
     * username
     *
     * @var mixed
     */
    private $username;    

    /**
     * dbname
     *
     * @var mixed
     */
    private $dbname;    

    /**
     * table
     *
     * @var mixed
     */
    private $table;

    /**
     * __construct
     *
     * @param  mixed $server
     * @param  mixed $username
     * @param  mixed $dbname
     * @param  mixed $table
     * @return void
     */
    public function __construct(string $server, string $username, ?string $dbname = null, ?string $table = null)
    {
        
        $this->server = $server;
        $this->username = $username;
        $this->dbname = $dbname;
        $this->table = $table;

    }
    
    /**
     * typeInt
     *
     * @param  mixed $data
     * @return int
     */
    public function Int($data):int
    {

        return (integer) $data;

    }
    
    /**
     * String
     *
     * @param  mixed $data
     * @return string
     */
    public function String($data):string
    {

        return (string) $data;

    }
    
    /**
     * Float
     *
     * @param  mixed $data
     * @return float
     */
    public function Float($data):float
    {

        return (float) floor($data);

    }
    
    /**
     * Date
     *
     * @param  mixed $data
     * @return string
     */
    public function Date($data):string
    {

        $validate = Validator::field('date', $data)
            ->with('date', function($validator) {
                $validator->validation('date');
            })
            ->make();

        return $validate->validated === false ? '0000-00-00 00:00:00' : $data;

    }

}