<?php

namespace System\Codememory\AbstractComponent\Repository;

/**
 * Interface RepositoryInterface
 * @package System\Codememory\AbstractComponent\Repository
 */
interface RepositoryInterface
{

    /**
     * @param $table
     *
     * @return mixed
     */
    public function all($table);

    /**
     * @param $table
     * @param $where
     *
     * @return mixed
     */
    public function specific($table, array $where, array $params);

    /**
     * @param $table
     * @param   array $data
     * @param   array $where
     *
     * @return mixed
     */
    public function update($table, array $data, array $where);

    /**
     * @param $table
     * @param   array $where
     *
     * @return mixed
     */
    public function delete($table, array $where);

    /**
     * @param $table
     *
     * @return mixed
     */
    public function deleteAll($table);

}