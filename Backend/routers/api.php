<?php

use Config\BaseUrl;
use Config\Urls;

$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));
$method = strtolower($_SERVER['REQUEST_METHOD']);

if (!in_array($request[0], array_column(Urls::cases(), 'value'))) {
    header('HTTP/1.0 404 Not Found', true, 404);
    $response = ['message' => 'url not found'];
    echo (json_encode($response));
    die();
}
switch ($request[0]) {
    case BaseUrl::PRODUCTS->value:
        include __DIR__ . '/products.php';
        break;
    case BaseUrl::CATEGORIES->value:
        include __DIR__ . '/categories.php';
        break;
    default:
        header('HTTP/1.0 404 Not Found', true, 404);
        $response = ['message' => 'base url not found'];
        echo (json_encode($response));
        die();

        break;
}
