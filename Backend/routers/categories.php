<?php

use Config\Methods;
use Config\Urls;
use Controllers\CategoryController;
use Routers\Router;

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
        header('HTTP/1.0 404 Not Found', true, 404);
        $response = ['message' => 'method not supported'];
        echo (json_encode($response));
        die();
}
