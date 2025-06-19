<?php
require_once __DIR__.'/vendor/autoload.php';
define('PROJECT_ROOT', dirname(__DIR__));

use app\core\Database;
use migrations\Migration_001_init_tables;

$db = Database::getInstance();
$migration = new Migration_001_init_tables();

$action = $argv[1] ?? 'up';
if ($action === 'up') {
    $migration->up();
    echo "Миграции успешно применены\n";
} elseif ($action === 'down') {
    $migration->down();
    echo "Миграции успешно отменены\n";
}