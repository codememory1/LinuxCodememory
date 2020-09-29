<?php

namespace System\Pagination;

use \Db;
use \Validator;
use System\Codememory\RegisterService;

/**
 * Class Paginator
 * @package System\Pagination
 */
class Paginator extends RegisterService
{

    /**
     * @var int
     */
    private $total;

    /**
     * @var int
     */
    private $current;

    /**
     * @var int
     */
    private $records = 5;

    /**
     * @var int
     */
    private $btn = 8;

    /**
     * @var string
     */
    private $table;

    /**
     * @var string
     */
    private $view = '../system/Pagination/View/%s';

    /**
     * Paginator constructor.
     */
    public function __construct()
    {
        parent::__construct();


    }

    /**
     * @param $table
     *
     * @return $this
     */
    public function table($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @param $quantity
     *
     * @return $this
     */
    public function records($quantity)
    {
        $this->records = $quantity;

        return $this;
    }

    /**
     * @param $quantity
     *
     * @return $this
     */
    public function buttons($quantity)
    {
        $this->btn = ($quantity > $this->totalBtn()) ? $this->totalBtn() : $quantity;

        return $this;
    }

    /**
     * @return mixed
     */
    private function total()
    {
        return Db::count()->table($this->table)->sql();
    }

    /**
     * @return float|int|mixed
     */
    public function current()
    {

        $pages = $this->request->get('get', 'page');

        $current = ($pages < 1) ? 1 : $pages;
        $current = ($current > $this->total()) ? $this->total() : $current;

        $current = $this->current = ($current - 1) * $this->records;

        return $current;

    }

    /**
     * @return int
     */
    private function getCurrent()
    {

        $pages = $this->request->get('get', 'page');

        $current = ($pages < 1) ? 1 : $pages;
        $current = ($current > $this->totalBtn()) ? $this->totalBtn() : $current;

        return (int) $current;

    }

    /**
     * @return false|float
     */
    private function totalBtn()
    {
        return ceil($this->total() / $this->records);
    }

    public function renderBtn()
    {

        ob_start();
        ob_implicit_flush(0);
        ob_get_clean();

        require 'View/PaginatorView.php';

    }

}