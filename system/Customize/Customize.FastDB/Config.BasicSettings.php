<?php

return [
	
	/* Пути к базе, таблицам, пользователям */
	'patchDbs'      => 'FastDB/Server/%server/Databases/Database/',
	'patchTables'   => 'FastDB/Server/%server/Tables/Tables/',
	'patchUsers'    => 'FastDB/Server/%server/Users/Users/',
	'listUsers'		=> 'FastDB/Server/%server/Users/',
	'notifications' => 'FastDB/Server/%server/Users/Users/%user/Notification/',
	'patchImport'   => 'FastDB/Server/%server/Tables/Import/',
	'representation'   => 'FastDB/Server/%server/Representation/',
	'patchServer'   => 'FastDB/Server',
	
	/* Основные название */
	'database' 	   => 'user=%user&database=%database',
	'tablesFile'   => 'database=%database&table=%table',
	'tablesDir'    => 'database=%database&data&table=%table',
	'notification' => 'notification@%user@%randomStr'
	
];