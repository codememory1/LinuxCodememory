<?php

namespace System\Codememory\AbstractComponent\Repository;

use System\Codememory\AbstractComponent\Repository\RepositoryInterface;
use \Db;

/**
 * Class Repository
 * @package System\Codememory\AbstractComponent\Repository
 */
abstract class Repository implements RepositoryInterface
{

    /**
     * @param $table
     *
     * @return mixed
     */
    public function all($table)
    {

        return Db::select()->table($table)->sql();

    }

    /**
     * @param $table
     * @param   array $where
     *
     * @return mixed
     */
    public function specific($table, array $where, array $params)
    {

        return Db::select()->table($table)->where($where)->sql($params)[0];

    }

    /**
     * @param $table
     * @param   array $data
     * @param   array $where
     *
     * @return mixed
     */
    public function update($table, array $data, array $where)
    {

        return Db::update($table)->setUpdate($data)->where($where)->sql($where);

    }

    /**
     * @param   array $where
     *
     * @return mixed
     */
    public function delete($table, array $where)
    {

        return Db::delete()->table($table)->where($where)->sql($where);

    }

    /**
     * @param $table
     *
     * @return mixed
     */
    public function deleteAll($table)
    {

        return Db::delete()->table($table)->sql();

    }

}