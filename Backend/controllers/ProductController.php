<?php

namespace Controllers;

use Models\Product;
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
        $product = new Product($connection);
        $result = $product->all();
        echo (json_encode($result));
    }

    public function delete($connection)
    {
        $product = new Product($connection);
        $productIds =  $_GET;
        $request = new ProductDeleteRequest();
        $validated = $request->validate($productIds);
        echo (json_encode($validated));
        die();

        $result = $product->deleteAll($productIds);
        // echo(json_encode($result));
    }
    public function store($connection)
    {
        $product = new Product($connection);
        $request = new ProductRequest();
        $validated = $request->validate($_POST);
        echo (json_encode($validated));
        die();
        $result = $product->create($validated);
    }
}
