<?php

use System\Router\Router;

/* The whole list of routes  */

Router::any('/test', 'MainController@test')->name('test');

Router::get('/auth', 'MainController@auth')->name('auth');
Router::post('/auth/handle', 'MainController@authHandle')->name('auth-handle');
Router::get('/chat/:userid', 'MainController@chat')
->with('userid', '([0-9]+)')
->name('chat');
Router::post('/chat/send/:to', 'MainController@chatHandle')->name('chatHandle');
Router::post('/auth', 'MainController@auth')->name('auth');
Router::post('/auth/handler', 'MainController@handler')->name('auth-handler');

////////////////////////////////////////////////////////

Router::get('/documentation/doc', 'DatabaseController@docs')->name('FastDB.docs');

Router::get('/connection/:server/:login/:password', 'AuthController@connection')
	->with('server', '(.*)')
	->with('login', '(.*)')
	->with('password', '(.*)')
	->name('FastDB.local-connection');

Router::access('AccessInFastDB', function() {
	Router::group('/fastdb', function() {
		
		Router::access('FastDbDoAuth', function() {
			Router::get('/auth', 'AuthController@auth')->name('FastDB.auth');
			Router::post('/auth/handler', 'AuthController@authHandler')->name('FastDB.auth-handler');
		});

		Router::access('AuthFastDB', function() {
			Router::get('/customize-config', 'DatabaseController@customizeConfig')->name('FastDB.customize-config');
			Router::post('/representation/handler', 'DatabaseController@representationHandler')->name('FastDB.representation-handler');
			Router::get('/representation', 'DatabaseController@representation')->name('FastDB.representation');
			Router::get('/all-db', 'DatabaseController@allDb')->name('FastDB.all-db');
			Router::get('/settings', 'SettingsController@settings')->name('FastDB.settings');
			Router::get('/console', 'DatabaseController@console')->name('FastDB.console');
			Router::get('/logout', 'AuthController@logout')->name('FastDB.logout');
			Router::get('/auth/confirm', 'AuthController@confirm')->name('FastDB.configm-auth');
			Router::post('/auth/confirm/handler', 'AuthController@confirmHandler')->name('FastDB.configm-auth-handler');
			Router::get('/additional-memory', 'DatabaseController@additionalMemory')->name('FastDB.additional-memory');
			Router::get('/history', 'HistoryController@view')->name('FastDB.list-history');
			Router::get('/history/delete/:id', 'HistoryController@delete')
			->with('id', '([0-9]+)')
			->name('FastDB.history-delete');
			Router::get('/remote-data-storage', 'StorageController@view')->name('FastDB.remote-data-storage');

			Router::group('/db', function() {
				Router::get('/create', 'DatabaseController@createDb')->name('FastDB.create-db');
				Router::post('/create/handler', 'DatabaseController@createDbHandler')->name('FastDB.create-db-handler');
				Router::get('/delete', 'DatabaseController@deleteDb')->name('FastDB.delete-db');
				Router::get('/open', 'DatabaseController@open')->name('FastDB.open-db');
			});
			Router::group('/table',function() {
				Router::get('/create/:db', 'TableController@createTable')
					->with('db', '([a-z0-0\_\-\.]+)')
					->name('FastDB.create-table');
				Router::post('/create/handler', 'TableController@createTablebHandler')->name('FastDB.create-table-handler');
				Router::get('/delete', 'TableController@delete')->name('FastDB.delete-table');
				Router::get('/settings', 'TableController@settings')->name('FastDB.settings-table');
				Router::post('/settings/handler', 'TableController@settingsHandler')->name('FastDB.settings-table-handler');
				Router::get('/watch/:db/:table', 'TableController@watch')
				->with('db', '([a-zA-Z-0-9\-\_\.]+)')
				->with('table', '([a-zA-Z-0-9\-\_\.]+)')
				->name('FastDB.watch-table');
				Router::any('/delete/selection', 'TableController@deleteSelection')->name('FastDB.delete-selection-record');
				Router::get('/cleans', 'TableController@cleans')->name('FastDB.cleans-table');
				Router::get('/embed', 'TableController@embed')->name('FastDB.embed-data');
				Router::post('/embed/handler', 'TableController@embedHandler')->name('FastDB.embed-data-handler');
				Router::get('/edit/data', 'TableController@editData')->name('FastDB.edit-data-table');
				Router::post('/edit/data/handler', 'TableController@editDataHandler')->name('FastDB.edit-data-table-handler');
				Router::get('/edit/structure', 'TableController@editStructure')->name('FastDB.edit-structure');
				Router::post('/edit/structure/handler', 'TableController@editStructureHandler')->name('FastDB.edit-structure-handler');
			});
			Router::group('/settings', function() {
				Router::post('/saving-deleted-data', 'SettingsController@saveingDeletedData')->name('FastDB.saving-deleted-data');
				Router::post('/turn-deleted-data', 'SettingsController@turnDeletedData')->name('FastDB.turn-deleted-data');
				Router::get('/update-user-token', 'SettingsController@updateUserToken')->name('FastDB.update-user-token');
				Router::post('/save', 'SettingsController@save')->name('FastDB.save-settings');
			});
			Router::group('/users', function() {
				Router::get('/list', 'UsersController@list')->name('FastDB.list-users');
				Router::post('/banned-account', 'UsersController@bannedAccount')->name('FastDB.banned-account');
				Router::get('/create', 'UsersController@create')->name('FastDB.create-user');
				Router::get('/delete', 'UsersController@deleteUser')->name('FastDB.delete-user');
				Router::post('/create/handler', 'UsersController@createHandler')->name('FastDB.create-user-handler');
				Router::get('/edit/access', 'UsersController@editAccess')->name('FastDB.edit-access');
				Router::post('/edit/access/handler', 'UsersController@editAccessHandler')->name('FastDB.edit-access-handler');
				Router::get('/edit', 'UsersController@editUser')->name('FastDB.edit-user');
				Router::post('/edit/handler', 'UsersController@editUserHandler')->name('FastDB.edit-user-handler');
			});

			Router::get('/db-interface', function() {
				view()->big('db-interface');
			})->name('FastDB.db-interface');

		});
	});	
});

