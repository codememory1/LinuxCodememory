<?php

namespace App\ControllersObserver;

use System\Codememory\AbstractComponent\ControllersObserver\Observer;
use System\Codememory\AbstractComponent\Interfaces\ControllerInterface;
use Request;
use Store;
use Date;

/**
 * ObserverMain
 */
class ObserverMain extends Observer
{

    public function observe()
    {

        $this->setObserve(
            new \App\Controllers\DatabaseController,
            new \App\Controllers\HistoryController,
            new \App\Controllers\SettingsController,
            new \App\Controllers\TableController,
            new \App\Controllers\UsersController,
            new \App\Controllers\AuthController
        );

    }

    private function autoDeleteTableData()
    {

        $pathServers = 'FastDB/Servers/';
        $pathDbUsers = 'FastDB/Servers/%s/Databases/';

        foreach(Store::scan($pathServers) as $server)
        {
            $fullPathDb = sprintf($pathDbUsers, $server);

            foreach(Store::scan($fullPathDb) as $username)
            {
                $pathDb = $fullPathDb.$username.'/';

                foreach(Store::scan($pathDb) as $dbname)
                {
                    $pathDbInTable = $pathDb.$dbname.'/Tables/';

                    if(is_array(Store::scan($pathDbInTable))) {
                        foreach(Store::scan($pathDbInTable) as $tablename)
                        {
                            $pathTable = $pathDbInTable.$tablename.'/';
    
                            Store::editJsonFile($pathTable.'data.fd')
                                ->editJsonData(function($datas) {
                                    foreach($datas['data'] as $k => $data) {
                                        if(isset($data['life']) && $data['life'] >= 0) {
                                            if(Date::unix() > $data['life']) {
                                                unset($datas['data'][$k]);
                                            }
                                        }
                                    }
                                    return $datas;
                                });
                        }
                    }
                }
            }
        }

    }

    public function supplement(ControllerInterface $controller)
    {

       $this->autoDeleteTableData();

    }

}