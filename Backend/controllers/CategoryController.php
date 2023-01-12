<?php

namespace Controllers;

use Models\Category;

class CategoryController
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

    public static function getInstance(): CategoryController
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    public function index($connection)
    {
        $category = new Category($connection);
        $result = $category->all();
        echo (json_encode($result));
    }
    public function show($connection,$id) {
        $category = new Category($connection);
        $result = $category->find($id);
        echo (json_encode($result));

    }

  
    
}
