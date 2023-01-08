<?php

namespace Controllers;

use Models\Product;

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
        echo(json_encode($result));
    
    }
}
