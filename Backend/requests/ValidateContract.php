<?php

namespace Requests;

interface ValidateContract
{
    public function validate(array $data): array;
    public function __construct(array $rules);
}
