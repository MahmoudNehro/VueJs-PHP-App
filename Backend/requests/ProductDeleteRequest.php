<?php

namespace Requests;

use PDO;

class ProductDeleteRequest implements ValidateContract
{
    public function __construct(protected ?array $rules = null,protected ?PDO $connection = null)
    {
        $this->rules = $this->rules ?? [
            'product_ids' => 'array|required',
            'product_ids.*' => 'required|numeric'
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
                if ($rule == 'array') {
                    if (isset($data[$key]) && !is_array($data[$key])) {
                        $errors[$key] = $key . ' must be array';
                    }
                }
                if ($rule == 'required' && strpos($key, '*') !== false) {
                    $key = substr($key, 0, strpos($key, '*') - 1);
                    if (isset($data[$key]) && is_array($data[$key])) {
                        foreach ($data[$key] as $item) {
                            if (!isset($item) || $item == '') {
                                $errors[$key] =  'id is required';
                            }
                            if (isset($item) && !is_numeric($item)) {
                                $errors[$key] = 'id must be numeric';
                            }
                        }
                    }
                }
               
            }
        }
        
        return $errors;
    }
}