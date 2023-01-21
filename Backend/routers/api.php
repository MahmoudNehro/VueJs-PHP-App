<?php

use Config\BaseUrl;
use Config\Urls;
use Helpers\ApiResponse;

$url = isset($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : $_SERVER['REQUEST_URI'];


$request = explode("/",$url );
$method = strtolower($_SERVER['REQUEST_METHOD']);

if (!in_array($request[1], array_column(Urls::cases(), 'value'))) {
    ApiResponse::response('not found', 404, 'url not found');
    die();
}
switch ($request[1]) {
    case BaseUrl::PRODUCTS->value:
        include __DIR__ . '/products.php';
        break;
    case BaseUrl::CATEGORIES->value:
        include __DIR__ . '/categories.php';
        break;
    default:
        ApiResponse::response('not found', 404, 'url not found');

        die();

        break;
}
