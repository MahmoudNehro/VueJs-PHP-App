<?php

use Database\MySQLConnection;
require_once('config/env.php');
require_once('vendor/autoload.php');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$connectionInstance = MySQLConnection::getInstance();
$connectionInstance->createConnection(env('host'), env('data_base'), env('user'), env('password'));
$connection = $connectionInstance->getConnection();


include __DIR__ . '/routers/api.php';
