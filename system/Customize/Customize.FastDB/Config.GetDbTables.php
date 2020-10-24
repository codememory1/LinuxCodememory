<?php

/**
 * @return array
 */
function writeDbTables($username, $server)
{

    $server = $server ?? Session::get('FastDBAuth')['server'];
    $username = $username ?? Session::get('FastDBAuth')['username'];

    $dbs = Store::scan('FastDB/Server/'.$server.'/Databases/Database/'.$username);

    $tables = Store::scan('FastDB/Server/'.$server.'/Tables/Tables/'.$username);
    $tables = array_combine($tables, $tables);  
    $tables_combine = [];
    
    foreach($tables as $combine_tbl)
    {
        if(strpos($combine_tbl, '.json'))
        {
            $tables_combine[$combine_tbl] = $combine_tbl;
        }
    }
    
    $dbArr = [];
    $tblArr = [];

    foreach($dbs as $db)
    {
        list($user, $db) = explode('database', $db);
        list($db, $format) = explode('.json', $db);

        $dbArr['database='.substr($db, 1)] = [];
    }

    foreach($tables_combine as $tblK => $tblV)
    {
        list($db, $table) = explode('&', $tblK);
        $dbArr[$db][] = $db.'&'.$table;
    }
    
    Store::createDir('FastDB/Server/'.$server.'/Databases/Database/'.$username);
    Store::createDir('FastDB/Server/'.$server.'/Tables/Tables/'.$username);

    return $dbArr;

}

/**
 * @return array
 */
function getDbTables($username = null, $server = null)
{
    return writeDbTables($username, $server);
}
