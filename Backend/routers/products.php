<?php

use Config\Methods;
use Config\Urls;
use Controllers\ProductController;
use Routers\Router;

$productController = ProductController::getInstance();


switch ($method) {
    case Methods::GET->value:
        Router::get(Urls::PRODUCTS->value, function () use ($productController, $connection) {
            $productController->index($connection);
        });
        break;
    case Methods::POST->value:
        Router::post(Urls::PRODUCTS->value, function () use ($productController, $connection) {
            $productController->store($connection);
        });
        break;
    case  Methods::DELETE->value:
        Router::delete(Urls::PRODUCTS_DELETE->value, function () use ($productController, $connection) {
            $productController->delete($connection);
        });
        break;
    default:
        header('HTTP/1.0 404 Not Found', true, 404);
        $response = ['message' => 'method not supported'];
        echo (json_encode($response));
        die();
}
