<?php

namespace Controllers;

use Helpers\ApiResponse;
use Models\Product\ProductCrud;
use Models\Product\ProductList;
use Requests\ProductDeleteRequest;
use Requests\ProductRequest;

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
        $product = new ProductList($connection);
        $result = $product->all();
        ApiResponse::response($result, 200, 'success');
    }
    public function delete($connection)
    {
        $product = new ProductCrud($connection);
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
        $product = new ProductCrud($connection);

        $request = new ProductRequest(null, $connection);
        $errors = $request->validate($_POST);
        if (count($errors) > 0) {
            ApiResponse::response($errors, 400, 'error');
            die();
        }
        $result =  $product->createProduct($_POST['category_id'], $_POST);
        ApiResponse::response($result, 200, 'data created successfully');
    }
}
