<?php

namespace Migrations\FastDB;

use System\Database\FastDB\WorkInterface\ComponentsHandler\Migration\ {
    InterfaceMigration,
    MigrationInterfaces\UserDataInterface as UserData,
    MigrationInterfaces\UserPrivilegesInterface as Privileges
};

/**
 * Class M2020_10_18_20_01_06_CreateTable
 * @package Migrations\FastDB
 */
class M2020_10_18_20_01_06_CreateTable extends InterfaceMigration
{

    public function execute()
    {

        return $this->username('games_akk')->editPrivileges(function($privilege) {
            $privilege->setPrivilege(Privileges::EDIT_RECORDS, true)
                ->setPrivilege(Privileges::CREATE_TABLES, true);
        })->exec();

    }

}