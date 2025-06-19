<?php
require_once __DIR__.'/../vendor/autoload.php';
define('PROJECT_ROOT', dirname(__DIR__));

use app\core\Application;

$app = new Application(PROJECT_ROOT);

require_once __DIR__.'/../routes/web.php';
require_once __DIR__.'/../routes/api.php';

$app->run();