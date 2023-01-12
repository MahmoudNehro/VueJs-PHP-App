<?php

namespace Models;

use PDO;

class Category extends Model
{
  protected string $table = 'categories';
  protected array $properties = ['id', 'name'];
  public function all()
  {
    $query = "SELECT {$this->properties[0]}, {$this->properties[1]} FROM {$this->table}";
    $stmt = $this->connection->prepare($query);
    $stmt->execute();
    $categories_array = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $category_item = array(
        'id' => $id,
        'name' => $name
      );
      $categories_array[] = $category_item;
    }
    return $categories_array;
  }
  public function create(array $data)
  {
    $query = "INSERT INTO {$this->table} (name) VALUES (:name)";
    $stmt = $this->connection->prepare($query);
    $stmt->execute($data);
  }
  public function deleteAll(array $ids)
  {
    $query = "DELETE FROM {$this->table} WHERE id IN (:ids)";
    $stmt = $this->connection->prepare($query);
    $stmt->execute($ids);
  }
  public function find(int $id)
  {
    $query = "SELECT a.name as attribute_name,
    a.id as attribute_id,
    u.name as unit_name,
    c.{$this->properties[0]}, c.{$this->properties[1]}  FROM {$this->table} c 
    JOIN attributes a ON a.category_id = c.id JOIN units u ON  u.id = a.unit_id  WHERE c.id = :id";

    $stmt = $this->connection->prepare($query);
    $stmt->execute(['id' => $id]);
    $cateogry_array = array();
    $category_item['data'] = array();
    $attributes = array();
    $i = 0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $attributeItem = array(
        'attribute_name' => $attribute_name,
        'unit_name' => $unit_name,
        'attribute_id' => $attribute_id

      );

      array_push($attributes, $attributeItem);

      $categoryOneItem = array(
        'id' => $id,
        'name' => $name,
        'attribute_category' => array_values($attributes)
      );

      $cateogry_array['data'][$id] =  $categoryOneItem;
      $i++;
    }
    $category_item['data'] = array_values($cateogry_array['data']);

    return $category_item;
  }
}
