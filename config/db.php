<?php
namespace app\config;

class db {
    public static function getConfig() {
        return [
            'host' => 'localhost',
            'dbname' => 'coworking',
            'user' => 'postgres',
            'password' => '12345678',
            'port' => '5432',
            'driver' => 'pgsql'
        ];
    }
}