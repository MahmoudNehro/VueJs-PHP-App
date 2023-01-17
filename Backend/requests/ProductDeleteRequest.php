<?php

namespace Requests;

class ProductDeleteRequest implements ValidateContract
{
    public function __construct(protected array $rules)
    {
        $this->rules = [
            'product_ids' => 'required'
        ];
    }
    public function validate(array $data): array
    {
        $errors = [];
        foreach ($this->rules as $key => $value) {
            $rules = explode('|', $value);
            foreach ($rules as $rule) {
                if ($rule == 'required') {
                    if (!isset($data[$key])) {
                        $errors[$key] = $key . ' is required';
                    }
                }
            }
        }
        return $errors;
    }
}