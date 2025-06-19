<?php
use app\core\Router;
use app\controllers\api\BookingController;
use app\controllers\api\ReviewController;
use app\controllers\api\SpaceController;
use app\controllers\api\UserController;

$router = new Router(new \app\core\Request());

$router->get('/api/spaces', [SpaceController::class, 'index']);
$router->get('/api/spaces/featured', [SpaceController::class, 'featured']);
$router->get('/api/spaces/{id}', [SpaceController::class, 'show']);
$router->post('/api/spaces', [SpaceController::class, 'store']);
$router->put('/api/spaces/{id}', [SpaceController::class, 'update']);
$router->delete('/api/spaces/{id}', [SpaceController::class, 'destroy']);

$router->get('/api/bookings', [BookingController::class, 'index']);
$router->get('/api/bookings/my', [BookingController::class, 'userBookings']);
$router->post('/api/bookings', [BookingController::class, 'store']);
$router->put('/api/bookings/{id}/status', [BookingController::class, 'updateStatus']);
$router->delete('/api/bookings/{id}', [BookingController::class, 'destroy']);

$router->get('/api/users', [UserController::class, 'index']);
$router->get('/api/users/{id}', [UserController::class, 'show']);
$router->put('/api/users/{id}', [UserController::class, 'update']);
$router->delete('/api/users/{id}', [UserController::class, 'destroy']);

$router->get('/api/reviews', [ReviewController::class, 'index']);
$router->post('/api/reviews', [ReviewController::class, 'store']);