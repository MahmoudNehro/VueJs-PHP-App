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
    $products_array['data'] = array_values($products_array['data']);

    return $products_array;
  }
  public function create(array $data)
  {
    $query = "INSERT INTO {$this->table} ({$this->properties[1]}, {$this->properties[2]}, {$this->properties[3]} ,
     {$this->properties[4]}) VALUES (:name, :sku, :price, :category_id)";
    $stmt = $this->connection->prepare($query);
    //validation 
    $name = htmlspecialchars(strip_tags($_POST['name']));
    $sku = htmlspecialchars(strip_tags($_POST['sku']));
    $price = htmlspecialchars(strip_tags($_POST['price']));
    $category_id = htmlspecialchars(strip_tags($_POST['category_id']));
    $attributes = $_POST['attributes'];
    $columnsNumber = count($attributes[0]);
    $rowsNumber = count($attributes);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':sku', $sku);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':category_id', $category_id);
    if ($stmt->execute()) {
      $product_id = $this->connection->lastInsertId();
      $queryAttributes = "INSERT INTO attribute_product (product_id, attribute_id, value) VALUES(?, ?, ?) , (?, ?, ?)";
      $stmtAttributes = $this->connection->prepare($queryAttributes);
      $stmtAttributes->bindParam(1, $product_id);
      $stmtAttributes->bindParam(2, $attributes[0]['id']);
      $stmtAttributes->bindParam(3, $attributes[0]['value']);
      $stmtAttributes->bindParam(4, $product_id);
      $stmtAttributes->bindParam(5, $attributes[1]['id']);
      $stmtAttributes->bindParam(6, $attributes[1]['value']);
      $stmtAttributes->execute();

      return true;
    }
    printf("Error: %s.\n", $stmt->errorInfo());
    return false;
  }
  public function deleteAll(array $ids)
  {
    $query = "DELETE FROM {$this->table} WHERE id IN  (" . implode(',', $ids) . " )";
    $stmt = $this->connection->prepare($query);
    $stmt->execute();
  }
}
