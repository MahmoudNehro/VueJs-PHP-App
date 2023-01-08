<?php

use Config\Urls;

$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));
$method = $_SERVER['REQUEST_METHOD'];

if (!in_array($request[0], array_column(Urls::cases(),'value'))) {
    header('HTTP/1.0 404 Not Found', true, 404);
    $response = ['message' => 'not found'];
    echo (json_encode($response));
    die();
}


include __DIR__ . '/products.php';
