<?php

use System\Codememory\Console\SocketServers;

$server = new SocketServers();

/** =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-REGISTRATION=-=-=-=-=-=-=-=-=-=-=-=-=-=-=- */

$server->register('Chat', Chat::class, 'execute');








/** =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-RUN=-=-=-=-=-=-=-=-=-=-=-=-=-=-=- */
$server->executes(2021);