<?php
function getServerErrorMessage(): array
{
    return [
        'success' => false,
        'error' => [
            'code' => 500,
            'message' => 'server errors'
        ]
    ];
}
