<?php

use System\Support\Session\Flash;
use System\Http\Response;

$responce = new Response();
$session = new Flash();

echo $responce->arrayToJson($session->get('error'));