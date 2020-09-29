<?php

namespace App\Controllers;

use System\Codememory\AbstractComponent\Controller;
use System\Codememory\Components\HTMLView\HTML;

/**
 * Class
 * @package App\Consollers\HistoryController
 */
class HistoryController extends Controller
{
    
    /**
     * common
     *
     * @var mixed
     */
    private $common;

    /**
     * WebController constructor.
     *
     * @param $container
     */
    public function __construct()
    {
        parent::__construct();

        $this->common = $this->model->load('Common');
    }
    
    /**
     * view
     *
     * @return void
     */
    public function view()
    {

        $model = $this->model->load('History');
        $model->updateStatusReady();
        $html = new HTML();

        $view = [
            [
                'tag' => 'div',
                'add' => [
                    [
                        'tag' => 'div[style=margin: 10px;]',
                        'add' => [
                            [
                                'tag' => 'div',
                                'add' => [
                                    [
                                        'tag'     => 'p',
                                        'content' => 'Вам прислали Таблицу: ',
                                        'add'     => [
                                            [
                                                'tag'     => 'mark',
                                                'content' => 'Users'
                                            ],
                                            [
                                                'tag'     => 'u[style=color:#dadada;padding-left: 10px;cursor:pointer;]',
                                                'content' => 'Просмотреть'
                                            ]
                                        ]
                                    ]
                                ]
                            ],
                            [
                                'tag' => 'br'
                            ],
                            [
                                'tag' => 'div',
                                'add' => [
                                    [
                                        'tag'     => 'p',
                                        'content' => 'Укажите название Базы Данных для сохранения Данной Таблицы'
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [
                        'tag' => 'div',
                        'add' => [
                            [
                                'tag' => 'input[type=text][class=db-name][placeholder=Название БД]'
                            ]
                        ]
                    ],
                    [
                        'tag'     => 'button[class=btn btn-success]',
                        'content' => 'Сохранить'
                    ]
                ]
            ]
        ];

        $model->create('cds', function($data) use($view, $html){
            $data->setTemplate($html->view($view))
            ->setDate('231')
            ->setUserData('333.333.33.33.3', 3333, 'default');
        })
        ->sendHistory();

        $this->view->big('history-all', ['history' => $model->getAll()]);
        
    }
    
    /**
     * delete
     *
     * @param  mixed $id
     * @return void
     */
    public function delete($id)
    {

        $model = $this->model->load('History');

        $model->deleteHistory($id);

    }
    
}