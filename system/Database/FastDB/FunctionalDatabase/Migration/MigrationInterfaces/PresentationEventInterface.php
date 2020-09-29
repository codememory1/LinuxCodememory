<?php

namespace System\Database\FastDB\FunctionalDatabase\Migration\MigrationInterfaces;

interface PresentationEventInterface
{
    
    const AUTH = 'auth';
    const CREATE_DB = 'create-db';
    const CREATE_TABLE = 'create-table';
    const NEW_TABLE_ENTRY = 'new-data-table';
    const UPDATE_STRUCTURE_TABLE = 'update-structure-table';
    const CREATE_USER = 'create-user';

}