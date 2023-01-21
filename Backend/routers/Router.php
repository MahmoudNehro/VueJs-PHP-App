<?php

namespace Routers;

use Config\Methods;
use Helpers\ApiResponse;

class Router
{


    public static function get(string $url, callable $function)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $serverUrl = isset($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : $_SERVER['REQUEST_URI'];
        $request = explode("/", $serverUrl);        
        if (strtolower($method) === strtolower(Methods::GET->value) &&  $request[1] === $url) {
            $function();
            die();
        } else if (strtolower($method) === strtolower(Methods::GET->value) && isset($request[2])) {
            $function();
            die();
        } else {
            $response = ['message' => 'the get request not found'];
            ApiResponse::response($response, 404, 'method not supported');

            die();
        }
    }
    public static function delete(string $url, callable $function)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $request = isset($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : $_SERVER['PATH_INFO'];
      
        if (strtolower($method) === strtolower(Methods::DELETE->value)  && substr($request,1) === $url) {
            $function();
            die();
        } else {
            $response = ['message' => 'the delete request not found'];
            ApiResponse::response($response, 404, 'method not supported');
            die();
        }
    }
    public static function post(string $url, callable $function)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $serverUrl = isset($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : $_SERVER['REQUEST_URI'];
        $request = explode("/", $serverUrl);        

        if (strtolower($method) === strtolower(Methods::POST->value) && $request[1] === $url) {
            $function();
            die();
        } else {
            $response = ['message' => 'the post request not found'];
            ApiResponse::response($response, 404, 'method not supported');
        }
    }
}
