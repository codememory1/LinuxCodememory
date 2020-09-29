<?php

namespace System\Codememory\AbstractComponent\Model;

/**
 * Class Handle
 * @package System\Codememory\AbstractComponent\Repository
 */
class Handle
{

    const PATCH_MODEL = 'App\\Models\\';

    /**
     * @param $model
     *
     * @return bool
     * @throws \ErrorException
     */
    private function hasRepository($model)
    {

        $model = $model.'Model';

        if(!class_exists(static::PATCH_MODEL.$model))
        {
            throw new \ErrorException(
                sprintf('Model {%s} not found.', $model)
            );
        }

        return true;
    }

    /**
     * @return array|false
     */
    public function lists()
    {

        $scan = scandir(static::PATCH_MODEL, SCANDIR_SORT_NONE);
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
    public function load($model)
    {

        if($this->hasRepository($model) === true)
        {

            $namespace_model = static::PATCH_MODEL.$model.'Model';

            return new $namespace_model();

        }

    }


}