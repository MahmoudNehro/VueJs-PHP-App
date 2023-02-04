<?php

namespace Models\Product;

use Models\Model;

abstract class Product extends Model
{
  protected string $table = 'products';
  protected array $properties = ['id', 'name', 'sku', 'price', 'category_id'];
 
  abstract public function create(array $data);
  public function sanitize($data)
  {
    $data = htmlspecialchars(strip_tags($data));
    return $data;
  }
}
