<?php
namespace app\config;

class db {
    public static function getConfig() {
        return [
            'host' => 'localhost',
            'dbname' => 'coworking',
            'user' => 'postgres',
            'password' => '',
            'port' => '5432',
            'driver' => 'pgsql'
        ];
    }
}