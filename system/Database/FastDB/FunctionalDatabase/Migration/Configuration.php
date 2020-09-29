<?php

namespace System\Database\FastDB\FunctionalDatabase\Migration;

/**
 * Configuration
 */
class Configuration
{

    const NAME_FILE_CONFIG = 'fastdb-conf.xml';
    const PATH_CONFIG = '/';
    
    /**
     * dataConfig
     *
     * @var array
     */
    private $dataConfig = [];
        
    /**
     * existsConfig
     *
     * @return void
     */
    public function existsConfig()
    {

        return file_exists(dirname(self::NAME_FILE_CONFIG));

    }
    
    /**
     * open
     *
     * @return void
     */
    public function open()
    {

        if($this->existsConfig() === true)
        {
            $this->dataConfig = json_encode(simplexml_load_file(dirname(dirname(dirname(dirname(dirname(__DIR__))))).'/'.self::NAME_FILE_CONFIG));
        }

        return $this;

    }
    
    /**
     * getData
     *
     * @param  mixed $key
     * @return void
     */
    public function getData($key)
    {

        $data = $this->dataConfig;
 
        $data = json_decode($data, true);

        $keys = explode('.', $key);

        foreach($keys as $conf)
        {
            $data = $data[$conf];
        }

        return $data;

    }

}