<?php
namespace Models\Product;

use Models\Model;

class ProductCrud extends Model
{
    protected string $table = 'products';
    protected array $properties = ['id', 'name', 'sku', 'price', 'category_id'];
  
    public function createProduct(int $type, array $data)
    {
      $lookupArray = [
        '1' => 'Book',
        '2' => 'DVD',
        '3' => 'Furnature'
      ];
  
      if (!array_key_exists($type, $lookupArray)) {
        throw new \RuntimeException('Incorrect product type');
      }
  
      $className = "Models\\Product\\" . $lookupArray[$type];
  
      return (new $className($this->connection))->create($data);
    }
  
    public function deleteAll(array $ids)
    {
      $query = "DELETE FROM {$this->table} WHERE id IN  (" . implode(',', $ids) . " )";
      $stmt = $this->connection->prepare($query);
      $stmt->execute();
  
      $rows = $stmt->rowCount();
  
      return (bool) $rows;
    }
}