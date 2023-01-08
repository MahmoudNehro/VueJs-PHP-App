<?php

function env(string $type) : string
{
    $envVariables =
        [
            'host' => 'localhost',
            'data_base' => 'scandiweb_task',
            'user' => 'root',
            'password' => ''
        ];
        if (!isset($envVariables[$type])) {
            return '';
        }
    return $envVariables[$type];
}
