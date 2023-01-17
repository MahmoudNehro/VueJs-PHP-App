<?php

namespace Requests;

use PDO;

interface ValidateContract
{
    public function validate(array $data): array;
    public function __construct(array $rules, PDO $connection=null);
}
