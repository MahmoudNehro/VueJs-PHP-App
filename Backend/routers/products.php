<?php

use Config\Methods;
use Config\Urls;
use Controllers\ProductController;

$productController = ProductController::getInstance();

if (strtolower($method) === strtolower(Methods::GET->value) && !isset($request[1]) && $request[0] === Urls::PRODUCTS->value) {
    $productController->index($connection);
}
if (strtolower($method) === strtolower(Methods::DELETE->value) && !isset($request[1]) && $request[0] === Urls::PRODUCTS->value) {
    $productController->delete($connection);
    
}
if (strtolower($method) === strtolower(Methods::POST->value) && !isset($request[1]) && $request[0] === Urls::PRODUCTS->value) {
    $productController->store($connection);
    
}
