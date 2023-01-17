<?php

namespace Controllers;

use Models\Product;
use Requests\ProductDeleteRequest;
use Requests\ProductRequest;
use Helpers\ApiResponse;

class ProductController
{
    private static $instances = [];

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): ProductController
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    public function index($connection)
    {
        $product = new Product($connection);
        $result = $product->all();
        ApiResponse::response($result, 200, 'success');
    }
    public function delete($connection)
    {
        $product = new Product($connection);
        $request = new ProductDeleteRequest();
        $errors = $request->validate($_GET);
        if (count($errors) > 0) {
            ApiResponse::response($errors, 400, 'error');
            die();
        }
        $validated =  $_GET['product_ids'];
        $result = $product->deleteAll($validated);
        if ($result) {
            ApiResponse::response($result, 200, 'success');
        } else {
            ApiResponse::response($result, 404, 'Not found');
        }
    }
    public function store($connection)
    {
        $product = new Product($connection);
        $request = new ProductRequest(null,$connection);
        $validated = $request->validate($_POST);
        if (count($validated) > 0) {
            ApiResponse::response($validated, 400, 'error');
            die();
        }
        $result = $product->create($validated);
        ApiResponse::response($result, 200, 'data created successfully');
    }
}
