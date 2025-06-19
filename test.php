<?php
require_once __DIR__ . '/vendor/autoload.php';

use app\core\Database;

$db = Database::getInstance();
echo "Успешно: подключение к БД\n";
