<?php

namespace Models;

use PDO;

class Product extends Model
{
  protected string $table = 'products';
  protected array $properties = ['id', 'name', 'sku', 'price', 'category_id'];
  public function all()
  {
    $query = "SELECT c.name as category_name,
        p.{$this->properties[0]},
        p.{$this->properties[1]},
        p.{$this->properties[2]},
        p.{$this->properties[3]},
        p.{$this->properties[4]},
        a.name as attribute_name,
        u.name as unit_name,
        ap.value
          FROM
          {$this->table}  p
           JOIN attribute_product ap ON p.id = ap.product_id
           JOIN attributes  a ON  ap.attribute_id = a.id
           JOIN units u ON u.id=a.unit_id
           JOIN categories c ON c.id=p.category_id
           ORDER BY 
          p.id ASC
          ";
    $stmt = $this->connection->prepare($query);
    $stmt->execute();
    $products_array = array();
    $products_array['data'] = array();
    $attributes = array();
    $i = 0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      if (isset($attributes[$i - 1]) && $attributes[$i - 1]['product_id'] != $id) {
        unset($attributes[$i - 1]);
      }
      $attributeItem = array(
        'product_id' => $id,
        'attribute_name' => $attribute_name,
        'unit_name' => $unit_name,
        'value' => $value

      );

      array_push($attributes, $attributeItem);

      $product_item = array(
        'id' => $id,
        'name' => $name,
        'sku' => $sku,
        'price' => $price,
        'category_id' => $category_id,
        'category_name' => $category_name,
        'attribute_items' => array_values($attributes)
      );

      $products_array['data'][$id] =  $product_item;
      $i++;
    }
    return array_values($products_array['data']);
  }
  public function create(array $data)
  {
    $query = "INSERT INTO {$this->table} ({$this->properties[1]}, {$this->properties[2]}, {$this->properties[3]} ,
     {$this->properties[4]}) VALUES (:name, :sku, :price, :category_id)";
    $stmt = $this->connection->prepare($query);
    $name = $this->sanitize($_POST['name']);
    $sku = $this->sanitize($_POST['sku']);
    $price = $this->sanitize($_POST['price']);
    $category_id = $this->sanitize($_POST['category_id']);
    $attributes = $_POST['attributes'];
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':sku', $sku);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':category_id', $category_id);
    $stmt->execute();
    $product_id = $this->connection->lastInsertId();
    
    $query = "INSERT INTO attribute_product (product_id, attribute_id, value) VALUES (:product_id, :attribute_id, :value)";
    $stmt = $this->connection->prepare($query);
    foreach ($attributes as $attribute) {
      $attribute_id = $this->sanitize($attribute['attribute_id']);
      $value = $this->sanitize($attribute['value']);
      $stmt->bindParam(':product_id', $product_id);
      $stmt->bindParam(':attribute_id', $attribute_id);
      $stmt->bindParam(':value', $value);
      $stmt->execute();
    }
  }
  public function deleteAll(array $ids)
  {
    $query = "DELETE FROM {$this->table} WHERE id IN  (" . implode(',', $ids) . " )";
    $stmt = $this->connection->prepare($query);
    $stmt->execute();

    $rows = $stmt->rowCount();

    return (bool) $rows;
  }

  public function sanitize($data)
  {
    $data = htmlspecialchars(strip_tags($data));
    return $data;
  }
}
