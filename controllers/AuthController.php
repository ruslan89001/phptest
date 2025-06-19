<?php
namespace app\controllers;

use app\core\Controller;
use app\models\User;
use app\services\AuthService;

class AuthController extends Controller {
    private AuthService $authService;

    public function __construct() {
        $this->authService = new AuthService();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->authService->login($_POST['email'], $_POST['password']);
            if ($user) {
                $_SESSION['user'] = $user;
                $this->redirect('/profile');
            }
            return $this->render('auth/login', ['error' => 'Invalid credentials']);
        }
        return $this->render('auth/login');
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User();
            $user->setUsername($_POST['username']);
            $user->setEmail($_POST['email']);
            $user->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));
            $user->setRole('user');

            try {
                $registeredUser = $this->authService->register($user);
                $_SESSION['user'] = $registeredUser;
                $this->redirect('/profile');
            } catch (\RuntimeException $e) {
                return $this->render('auth/register', ['error' => $e->getMessage()]);
            }
        }
        return $this->render('auth/register');
    }

    public function logout() {
        session_destroy();
        $this->redirect('/');
    }
}