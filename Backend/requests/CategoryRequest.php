<?php

namespace Requests;

use PDO;

class CategoryRequest implements ValidateContract {


    public function __construct(protected ?array $rules = null, protected ?PDO $connection = null)
    {
        $this->rules = $this->rules ?? [
            'id' => 'required|numeric',
        ];
    }

    public function validate(array $data): array
    {
        $errors = [];
        foreach ($this->rules as $key => $value) {
            $rules = explode('|', $value);
            foreach ($rules as $rule) {
                if ($rule == 'required') {
                    if (!isset($data[$key]) || $data[$key] == '') {
                        $errors[$key] = $key . ' is required';
                    }
                }
                if ($rule == 'numeric') {
                    if (isset($data[$key]) && !is_numeric($data[$key])) {
                        $errors[$key] = $key . ' must be numeric';
                    }
                }
            }
        }

        return $errors;
    }
    
   
}