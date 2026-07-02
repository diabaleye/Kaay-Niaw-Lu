<?php

return [
    /*
    |--------------------------------------------------------------------------
    | CORS — Cross-Origin Resource Sharing
    |--------------------------------------------------------------------------
    | Angular tourne sur localhost:4200 en dev.
    | En production, remplace par le domaine réel du frontend.
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'http://localhost:4200',   // Angular dev
        'http://localhost:4000',   // Angular prod preview (ng serve --port 4000)
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    // false = mode Bearer token (pas de cookies cross-site)
    'supports_credentials' => false,
];
