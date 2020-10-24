<?php

namespace System\Http\Access;

use System\Http\Access\Handle;
use File;
use Responce;

/**
 * Class Access
 * @package System\Http\Access
 */
class Access
{

    const PATCH_ACCESS = '../access/';

    public function __construct($loadAccess, $task)
    {
        $this->runAccess($loadAccess, $task);
    }

    /**
     * @return bool
     * @throws \ErrorException
     */
    protected function hasAccess()
    {
        if(!is_dir(self::PATCH_ACCESS))
        {
            throw new \ErrorException(
                sprintf('Dir {%s} not found.', self::PATCH_ACCESS)
            );
        }
        return true;
    }

    /**
     * @return array|bool
     * @throws \ErrorException
     */
    protected function lists()
    {

        if($this->hasAccess() === true)
        {
            $access = scandir(self::PATCH_ACCESS, SCANDIR_SORT_NONE);
            array_shift($access);
            array_shift($access);

            return ($this->hasAccess() === true) ? $access : $this->hasAccess();
        }

    }

    /**
     * @return mixed
     */
    protected function getCfg()
    {

        return config('access');

    }

    /**
     * @return string|string[]
     * @throws \ErrorException
     */
    protected function replaceAccess()
    {

        $list = $this->lists();

        return str_replace('Access.php', '', $list);

    }

    /**
     * @return array
     */
    protected function cycleFileAccess()
    {

        $file_replace = $this->replaceAccess();

        foreach($file_replace as $access)
        {

            return (array) down_line($access);

        }

    }

    /**
     * @return bool
     * @throws \ErrorException
     */
    protected function verFileCfg()
    {

        $cfgAccess = $this->getCfg();
        $arr_file = $this->cycleFileAccess();

        foreach($arr_file as $access)
        {

            if(!array_key_exists($access, $cfgAccess))
            {
                throw  new \ErrorException(
                    sprintf('Add to config {access} all access which are in the {%s} folder.', self::PATCH_ACCESS)
                );
            }

            return true;

        }

    }

    /**
     * @return mixed
     * @throws \ErrorException
     */
    protected function loadAccess($loadAccess)
    {

        $cfgAccess = $this->getCfg();

        if($this->verFileCfg() === true)
        {
            $namespace = $cfgAccess[$loadAccess];
            $class =  new $namespace();

            return $class->accessHandle();
        }

    }

    /**
     * @return mixed
     * @throws \ErrorException
     */
    protected function runAccess($loadAccess, $task)
    {

        if($this->loadAccess($loadAccess) === false)
        {
            return (is_null($task)) ? Responce::getCode(404) : die($task);
        }
        
        return $this->loadAccess($loadAccess);

    }

}