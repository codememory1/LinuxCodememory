<?php

namespace App\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use System\Codememory\AbstractComponent\Controller;
use System\Codememory\Components\HTMLView\HTML;
use System\Codememory\Components\Fakers\Faker;
use System\Inc\ConstructorCreate;
use System\Database\FastDB\WorkInterface\Connection;
use System\Database\FastDB\WorkInterface\ComponentsHandler\Migration\InterfaceMigration;
use System\Database\FastDB\WorkInterface\ComponentsHandler\Migration\ExecuteSettingsXml;

/**
 * Class
 * @package App\Consollers\MainController
 */
class MainController extends Controller
{

    /**
     * WebController constructor.
     *
     * @param $container
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    public function auth()
    {

    //    $files = [
    //        'system' => [
    //            'directory/' => [
    //                'red/' => [
    //                    'file.txt'
    //                ],
    //                'blue.txt'
    //            ]
    //        ]
    //    ];

    //    $file = new ConstructorCreate('/');

    //    $file->consider($files);

    //     $comp = new Connection();
    //     $connect = $comp->connect('333.333.33.33.3', 3333, 'default', null, 'Codememory');

    // $res = $connect->query('SHOW `ALL` OF TABLE `Shop` FLAGS{ NOT-IF(`id` `30`) }');

    //     debug($res);

        // debug(\File::ignore('node_modules', 'vendor')->search(['extension' => 'js'])->execSearch());

        // $i = new InterfaceMigration();

        // $r = $i->createDatabase('TestDatabase', function($sett) {
        //     $sett->charset('UTF-8');
        // })->exec();

// /        $n = new ExecuteSettingsXml();

        // echo $n->setSuccessLog('Создание Таблицы', '{status:success, message: "Error"}');

        // $this->view->big('test');

        $r = \Ini::parse('system/Database/FastDB/WorkInterface/ComponentsHandler/Migration/config')->data();

        debug($r);

        echo base_convert('2A43', 15, 2);
    }
    
}