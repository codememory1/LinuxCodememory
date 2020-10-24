<?php

namespace System\Database\FastDB\WorkInterface\ComponentsHandler\Migration\MigrationInterfaces;

interface UserPrivilegesInterface
{

    /** DATABASE */
    const CREATE_DATABASES = 'create-db';
    const DROP_DATABASES = 'delete-db';

    /** TABLE */
    const CREATE_TABLES = 'create-table';
    const DROP_TABLES = 'delete-table';
    const CLEAR_TABLES = 'cleans-table';
    const VIEW_TABLES = 'watch-table';
    const EDIT_RECORDS = 'edit-tabel-data';
    const ADD_RECORDS = 'embed-data-table';

    /** USER */
    const CREATE_USER = 'create-user';
    const REMOVE_USERS = 'delete-user';
    const VIEW_USER_LIST = 'check-all-users';
    const EDIT_PRIVILEGES_USER = 'edit-user-access';
    const EDIT_USER_DATA = 'edit-user-info';

}