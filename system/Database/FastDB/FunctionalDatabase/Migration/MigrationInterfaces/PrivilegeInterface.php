<?php

namespace System\Database\FastDB\Migration;

interface PrivilegeInterface
{
	
	const CREATE_DB = 'create-db';
	const EDIT_DB = 'edit-db';
	const DELETE_DB = 'delete-db';
	
	const CREATE_TABLE = 'create-table';
	const WATCH_TABLE = 'watch-table';
	const DELETE_TABLE = 'delete-table';
	const STRUCTURE_EDIT = 'edit-structure-table';
	const ADD_DATA = 'add-data-table';
	const EDIT_DATA = 'edit-data-table';
	const DELETE_DATA = 'delete-data-table';
	const EDIT_SETTINGS_TABLE = 'edit-settings-table';
	
	const CREATE_USER = 'add-users';
	const WATCH_USERS = 'watch-users';
	const EDIT_USER = 'edit-users';
	const DELETE_USER = 'delete-users';
	
}