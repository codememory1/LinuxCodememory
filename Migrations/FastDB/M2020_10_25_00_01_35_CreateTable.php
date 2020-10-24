<?php

namespace Migrations\FastDB;

use System\Database\FastDB\WorkInterface\ComponentsHandler\Migration\ {
    InterfaceMigration,
    MigrationInterfaces\UserDataInterface as UserData,
    MigrationInterfaces\UserPrivilegesInterface as Privileges
};

/**
 * Class M2020_10_25_00_01_35_CreateTable
 * @package 
 */
class M2020_10_25_00_01_35_CreateTable extends InterfaceMigration
{

    /** 
    *
    * @return executer
    */
    public function execute()
    {

        $exec = $this->createDatabase('TestDatabase2', function($sett) {
            $sett->charset('utf-8');
        })
        ->exec();

        return $exec;

    }

}