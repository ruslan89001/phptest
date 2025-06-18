<?php

use app\core\Application;
use app\core\Router;
use app\core\Session;
use app\core\Database;

require_once __DIR__.'/../vendor/autoload.php';

// Загрузка конфигурации
$config = [
    'db' => [
        'dsn' => 'pgsql:host=localhost;port=5432;dbname=coworking',
        'user' => 'postgres',
        'password' => 'your_password'
    ]
];

// Инициализация приложения
$app = new Application($config);

// Регистрация маршрутов
$router = new Router();

// Публичные маршруты
$router->get('/', 'HomeController', 'index');
$router->get('/spaces', 'SpaceController', 'index');
$router->get('/spaces/{id}', 'SpaceController', 'show');
$router->get('/login', 'AuthController', 'login');
$router->post('/login', 'AuthController', 'login');
$router->get('/register', 'AuthController', 'register');
$router->post('/register', 'AuthController', 'register');
$router->get('/logout', 'AuthController', 'logout');

// Личный кабинет
$router->get('/dashboard', 'DashboardController', 'index');
$router->get('/bookings', 'BookingController', 'index');
$router->get('/spaces/{id}/book', 'BookingController', 'create');
$router->post('/spaces/{id}/book', 'BookingController', 'create');

// Админ-панель
$router->get('/admin', 'AdminController', 'dashboard');
$router->get('/admin/spaces', 'AdminController', 'spaces');
$router->get('/admin/spaces/create', 'AdminController', 'createSpace');
$router->post('/admin/spaces', 'AdminController', 'storeSpace');
$router->get('/admin/spaces/{id}/edit', 'AdminController', 'editSpace');
$router->post('/admin/spaces/{id}', 'AdminController', 'updateSpace');
$router->post('/admin/spaces/{id}/delete', 'AdminController', 'deleteSpace');

// Запуск роутера
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$router->dispatch($uri, $method);