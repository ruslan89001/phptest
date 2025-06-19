<?php
use app\controllers\AuthController;
use app\controllers\MainController;
use app\controllers\SpaceController;
use app\controllers\BookingController;
use app\controllers\ReviewController;
use app\controllers\AdminController;
use app\core\Router;

$router = new Router(new \app\core\Request());

$router->get('/', [MainController::class, 'home']);
$router->get('/home', [MainController::class, 'home']);

$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'register']);
$router->post('/register', [AuthController::class, 'register']);
$router->post('/logout', [AuthController::class, 'logout']);

$router->get('/profile', [AuthController::class, 'profile']);
$router->post('/profile', [AuthController::class, 'updateProfile']);

$router->get('/spaces', [SpaceController::class, 'index']);
$router->post('/spaces', [SpaceController::class, 'store']);

$router->get('/bookings', [BookingController::class, 'index']);
$router->post('/bookings', [BookingController::class, 'store']);
$router->delete('/bookings/{id}', [BookingController::class, 'destroy']);

$router->get('/reviews', [ReviewController::class, 'index']);
$router->post('/reviews', [ReviewController::class, 'store']);

$router->get('/admin/users', [AdminController::class, 'viewUsers']);
$router->put('/admin/users/{id}', [AdminController::class, 'updateUser']);
$router->delete('/admin/users/{id}', [AdminController::class, 'deleteUser']);

$router->get('/admin/spaces', [AdminController::class, 'viewSpaces']);
$router->post('/admin/spaces', [AdminController::class, 'createSpace']);
$router->put('/admin/spaces/{id}', [AdminController::class, 'updateSpace']);
$router->delete('/admin/spaces/{id}', [AdminController::class, 'deleteSpace']);

$router->get('/admin/bookings', [AdminController::class, 'viewBookings']);
$router->put('/admin/bookings/{id}/status', [AdminController::class, 'updateBookingStatus']);
$router->delete('/admin/bookings/{id}', [AdminController::class, 'deleteBooking']);