<?php

use Config\Methods;
use Config\Urls;
use Controllers\ProductController;
use Routers\Router;
use Helpers\ApiResponse;
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
        ApiResponse::response($response, 404, 'method not supported');
        die();
}
