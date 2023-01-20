<?php

namespace Requests;

use PDO;

class ProductRequest implements ValidateContract
{


    public function __construct(protected ?array $rules = null, protected ?PDO $connection = null)
    {
        $this->rules = $this->rules ?? [
            'name' => 'required',
            'sku' => 'required|unique:products,sku',
            'price' => 'required|decimal',
            'category_id' => 'required|numeric',
            'attributes' => 'array|required',
            'attributes.*.id' => 'required',
            'attributes.*.value' => 'required'

        ];
    }
    public function validate(array $data): array
    {
        $errors = [];
        foreach ($this->rules as $key => $value) {
            $rules = explode('|', $value);
            foreach ($rules as $rule) {
                if ($rule == 'required' && strpos($key, '*') === false) {
                    if (!isset($data[$key]) || $data[$key] == '') {
                        $errors[$key] = $key . ' is required';
                    }
                }
                if ($rule == 'numeric') {
                    if (isset($data[$key]) && !is_numeric($data[$key])) {
                        $errors[$key] = $key . ' must be numeric';
                    }
                }
                if ($rule == 'decimal') {
                    $data[$key] = (float) $data[$key];

                    if (isset($data[$key]) && !is_float($data[$key])) {
                        $errors[$key] = $key . ' must be decimal';
                    }
                    if (isset($data[$key]) && $data[$key] <= 0) {
                        $errors[$key] = $key . ' must be valid number';
                    }
                }
                if ($rule == 'array') {
                    if (isset($data[$key]) && !is_array($data[$key])) {
                        $errors[$key] = $key . ' must be array';
                    }
                }
                if ($rule == 'required' && strpos($key, '*') !== false) {
                    $key = substr($key, 0, strpos($key, '*') - 1);

                    if (isset($data[$key]) && is_array($data[$key])) {
                        foreach ($data[$key] as $item) {
                            if (!isset($item['id']) || $item['id'] == '') {
                                $errors[$key] =  'id is required';
                            }
                            if (isset($item['id']) && !is_numeric($item['id'])) {
                                $errors[$key] = 'id must be numeric';
                            }
                            if (!isset($item['value']) || $item['value'] == '') {
                                $errors[$key] = 'value is required';
                            }
                            if (isset($item['value']) && !is_numeric($item['value'])) {
                                $errors[$key] = 'value must be numeric';
                            }
                        }
                    }
                }
                if (isset($data[$key]) && $rule == 'unique:products,sku') {
                    $table = substr($rule, strpos($rule, ':') + 1);
                    $table = explode(',', $table);
                    $table = $table[0];
                    $column = $table[1];
                    $query = "SELECT * FROM $table WHERE sku = :$column";
                    $stmt = $this->connection->prepare($query);
                    $stmt->execute([$column => $data[$key]]);
                    $result = $stmt->fetch();
                    $stmt->closeCursor();
                    if ($result) {
                        $errors[$key] = $key . ' already exists';
                    }
                }
            }
        }
        return $errors;
    }
}
