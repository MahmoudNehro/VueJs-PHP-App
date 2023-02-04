<?php

namespace Models\Product;

class DVD extends Product
{
    public function create(array $data)
    {
        $queryProducts = "INSERT INTO {$this->table} ({$this->properties[1]}, {$this->properties[2]}, {$this->properties[3]} ,
        {$this->properties[4]}) VALUES (:name, :sku, :price, :category_id)";
        $stmtProduct = $this->connection->prepare($queryProducts);
        $name = $this->sanitize($data['name']);
        $sku = $this->sanitize($data['sku']);
        $price = $this->sanitize($data['price']);
        $category_id = $this->sanitize($data['category_id']);
        $stmtProduct->bindParam(':name', $name);
        $stmtProduct->bindParam(':sku', $sku);
        $stmtProduct->bindParam(':price', $price);
        $stmtProduct->bindParam(':category_id', $category_id);
        $stmtProduct->execute();
        $product_id = $this->connection->lastInsertId();
        $attributes = $data['attributes'];
        $dvdAttribute = $attributes[0];
        $queryAttributes = "INSERT INTO attribute_product (product_id, attribute_id, value) VALUES (:product_id, :attribute_id, :value)";
        $stmtAttribute = $this->connection->prepare($queryAttributes);
        $attribute_id = $this->sanitize($dvdAttribute['id']);
        $value = $this->sanitize($dvdAttribute['value']);
        $stmtAttribute->bindParam(':product_id', $product_id);
        $stmtAttribute->bindParam(':attribute_id', $attribute_id);
        $stmtAttribute->bindParam(':value', $value);
        $stmtAttribute->execute();
        return (bool) $stmtProduct->rowCount();
    }
}
