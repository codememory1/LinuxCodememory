<?php

//  =============LANGUAGE============= 
$language['path'] = "resources/Lang/";
$language['name'] = "languages";
$language['auto_write'] = false;

//   =============LOG============= 
$enable_debug = true;
$write_log['enable'] = false;
$write_log['path'] = "storage/logs/error_log.log";

//  =============LISTENERS============= 
$server['pathRegitserServer'] = "app/Listeners/server-registration.php";
$server['namespace'] = "App\\Listeners\\%s";

//  =============SESSION============= 
$session['save'] = "storage/session/";
$session['encode'] = false;
$session['auto_delete'] = true;

//  =============EXPORT ALL VARS============= 
$allVars = get_defined_vars();

$_VARS["language"] = $language;
$_VARS["enable_debug"] = $enable_debug;
$_VARS["write_log"] = $write_log;
$_VARS["server"] = $server;
$_VARS["session"] = $session;
$_VARS["allVars"] = $allVars;


extract($_VARS);
/* Codememory Framework Compiler */