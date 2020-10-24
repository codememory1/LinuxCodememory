<?php

namespace System\Codememory\AbstractComponent\Repository;

use \Inc;

/**
 * Class Handle
 * @package System\Codememory\AbstractComponent\Repository
 */
class Handle
{

    const PATCH_REPOSITORY = '../app/Model/Repository/';
    const PATCH_REPOSITORY_FILE = '../app/Model/Repository/%sRepository.php';
    const PATCH_REPOSITORY_DIR_FILE = '../app/Model/Repository/%s/%sRepository.php';

    /**
     * @param $repository
     * @param   null $dir
     *
     * @return bool
     */
    private function hasRepository($repository, $dir = null)
    {

        if(empty($dir))
        {
            return (file_exists(sprintf(static::PATCH_REPOSITORY_FILE, $repository))) ? true : false;
        }
        return (file_exists(sprintf(static::PATCH_REPOSITORY_DIR_FILE, $dir, $repository))) ? true : false;
    }

    /**
     * @return array|false
     */
    public function lists()
    {

        $scan = scandir(static::PATCH_REPOSITORY, SCANDIR_SORT_NONE);
        array_shift($scan);
        array_shift($scan);

        return $scan;

    }

    /**
     * @param $repository
     * @param   null $dir
     *
     * @return mixed
     * @throws \ErrorException
     */
    public function load($repository, $dir = null)
    {

        $dir = (is_null($dir)) ? $dir : $dir.'\\';

        if($this->hasRepository($repository, $dir) === true)
        {

            $namespace_repository = 'App\\Model\\Repository\\'.$dir.$repository.'Repository';

            return new $namespace_repository();
        }
        throw new \ErrorException(
            sprintf('Repository {%s} not found.', $repository)
        );

    }


}