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

    $rowCount = $stmt->rowCount();
    if ($rowCount > 0) {
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
    } else {
      $products_array = array();
      $products_array['data'] = array();
    }
    return $products_array;
  }
  public function create(array $data)
  {
  }
  public function delete(int $id)
  {
  }
  public function deleteAll(array $ids)
  {
  }
  public function find(int $id)
  {
  }
}
