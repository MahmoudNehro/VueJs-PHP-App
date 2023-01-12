<?php

namespace Routers;

use Config\Methods;
use Config\Urls;

class Router
{


    public static function get(string $url, callable $function)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));

        if (strtolower($method) === strtolower(Methods::GET->value) && substr($_SERVER['PATH_INFO'], 1) === $url) {
            $function();
            die();
        } else if (strtolower($method) === strtolower(Methods::GET->value) && isset($request[1])) {
            $function();
            die();
        } else {
            header('HTTP/1.0 404 Not Found', true, 404);
            $response = ['message' => 'the get request not found'];
            echo (json_encode($response));

            die();
        }
    }
    public static function delete(string $url, callable $function)
    {
        $method = $_SERVER['REQUEST_METHOD'];

        if (strtolower($method) === strtolower(Methods::DELETE->value)  && substr($_SERVER['PATH_INFO'], 1) === $url) {
            $function();
            die();
        } else {
            header('HTTP/1.0 404 Not Found', true, 404);
            $response = ['message' => 'the delete request not found'];
            echo (json_encode($response));
            die();
        }
    }
    public static function post(string $url, callable $function)
    {
        $method = $_SERVER['REQUEST_METHOD'];

        if (strtolower($method) === strtolower(Methods::POST->value) && substr($_SERVER['PATH_INFO'], 1) === $url) {
            $function();
            die();
        } else {
            header('HTTP/1.0 404 Not Found', true, 404);
            $response = ['message' => 'the post request not found'];
            echo (json_encode($response));
            die();
        }
    }
}
