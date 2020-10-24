<?php

use System\Support\Random;
use System\ENV\AppEnv;
use System\Support\Common;

$common = new Common();

AppEnv::set('APP_NAME');
AppEnv::set('APP_KEY');
AppEnv::set('APP_IP');
AppEnv::set('APP_URL');
AppEnv::set('DATETIME');
AppEnv::set('APP_DEBUG');
AppEnv::set('APP_EMAIL');
AppEnv::set('LANG_SITES');
AppEnv::set('FOLDER_LANG');

/* База данных */

AppEnv::set('DB_CONNECTION');
AppEnv::set('DB_HOST');
AppEnv::set('DB_PORT');
AppEnv::set('DB_NAME');
AppEnv::set('DB_USERNAME');
AppEnv::set('DB_PASSWORD');
AppEnv::set('DB_CHARSET');

/* Mail */

AppEnv::set('MAIL_TITLE');
AppEnv::set('MAIL_NAME');
AppEnv::set('MAIL_HOST');
AppEnv::set('MAIL_USER');
AppEnv::set('MAIL_PASSWORD');
AppEnv::set('SMTPSecure_MAIL');
AppEnv::set('MAIL_PORT');
AppEnv::set('MAIL_CHARSET');
AppEnv::set('MAIL_HTML');

/* FastDB */

AppEnv::set('FastDB_SERVER');
AppEnv::set('FastDB_USERNAME');
AppEnv::set('FastDB_PASSWORD');
AppEnv::set('FastDB_DBNAME');
