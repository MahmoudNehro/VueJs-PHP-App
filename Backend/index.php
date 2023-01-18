<?php
require_once('config/allowCors.php');
cors();

use Database\MySQLConnection;

require_once('config/env.php');
require_once('vendor/autoload.php');
$connectionInstance = MySQLConnection::getInstance();
$connectionInstance->createConnection(env('host'), env('data_base'), env('user'), env('password'));
$connection = $connectionInstance->getConnection();


include __DIR__ . '/routers/api.php';
