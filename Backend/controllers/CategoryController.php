<?php

namespace Controllers;

use Models\Category;
use Helpers\ApiResponse;
use Requests\CategoryRequest;

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
        ApiResponse::response($result, 200, 'success');
    }
    public function show($connection,$id) {
        $category = new Category($connection);
        $request = new CategoryRequest();
        $errors = $request->validate(['id' => $id]);
        if (count($errors) > 0) {
            ApiResponse::response($errors, 400, 'category id not correct');
            die();
        }
        $result = $category->find($id);
        ApiResponse::response($result, 200, 'success');

    }

  
    
}
