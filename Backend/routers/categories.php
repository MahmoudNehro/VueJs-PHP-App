<?php

use Config\Methods;
use Config\Urls;
use Controllers\CategoryController;
use Routers\Router;
use Helpers\ApiResponse;
$categoryController = CategoryController::getInstance();

switch ($method) {
    case Methods::GET->value:
        $param = isset($request[1]) ? $request[1] : null;
        if ($param) {
            Router::get(Urls::CATEGORY->value, function () use ($categoryController, $connection , $param) {
                $categoryController->show($connection, $param);
            });
            break;

        }
        Router::get(Urls::CATEGORIES->value, function () use ($categoryController, $connection) {
            $categoryController->index($connection);
        });

        break;
    default:
        ApiResponse::response($response, 404, 'method not supported');
        die();
}
