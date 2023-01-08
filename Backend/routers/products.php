<?php

use Config\Methods;
use Config\Urls;
use Controllers\ProductController;

$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));

if (strtolower($method) === strtolower(Methods::GET->value) && !isset($request[1]) && $request[0] === Urls::PRODUCTS->value) {
    $productController = ProductController::getInstance();
    $productController->index($connection);
} 

