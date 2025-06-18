<?php

return [
    'db' => [
        'dsn' => $_ENV['DB_DSN'] ?? 'pgsql:host=localhost;port=5432;dbname=coworkingdb',
        'user' => $_ENV['DB_USER'] ?? 'postgres',
        'password' => $_ENV['DB_PASSWORD'] ?? '12345678'
    ],
    'app' => [
        'name' => 'CoworkingBooking',
        'env' => $_ENV['APP_ENV'] ?? 'production',
        'debug' => (bool)($_ENV['APP_DEBUG'] ?? false)
    ],
    'auth' => [
        'session_key' => 'coworking_user',
        'token_expiry' => 3600 * 24 * 30
    ]
];