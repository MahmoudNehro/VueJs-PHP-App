<?php

use Config\BaseUrl;
use Config\Urls;
use Helpers\ApiResponse;

$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));
$method = strtolower($_SERVER['REQUEST_METHOD']);

if (!in_array($request[0], array_column(Urls::cases(), 'value'))) {
    ApiResponse::response($response, 404, 'url not found');
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
        ApiResponse::response($response, 404, 'url not found');

        die();

        break;
}
