<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\mappers\UserMapper;
use app\models\User;

class AuthController extends Controller
{
    public function login(Request $request, Response $response)
    {
        if ($request->isPost()) {
            $email = $request->get('email');
            $password = $request->get('password');

            $userMapper = new UserMapper();
            $user = $userMapper->findByEmail($email);

            if (!$user || !$userMapper->verifyPassword($user, $password)) {
                $this->session->setFlash('error', 'Неверный email или пароль');
                return $this->render('auth/login');
            }

            $this->session->set('user_id', $user->id);
            $this->session->set('user_role', $user->role);

            if ($user->role === 'admin') {
                $response->redirect('/admin/dashboard');
            } else {
                $response->redirect('/dashboard');
            }
        }

        return $this->render('auth/login');
    }

    public function register(Request $request, Response $response)
    {
        if ($request->isPost()) {
            $user = new User();
            $user->loadData($request->getBody());

            $userMapper = new UserMapper();

            if ($userMapper->findByEmail($user->email)) {
                $this->session->setFlash('error', 'Пользователь с таким email уже существует');
                return $this->render('auth/register', ['model' => $user]);
            }

            if ($userMapper->save($user)) {
                $this->session->setFlash('success', 'Регистрация прошла успешно! Войдите в систему.');
                $response->redirect('/login');
            } else {
                $this->session->setFlash('error', 'Ошибка при регистрации');
            }
        }

        return $this->render('auth/register', ['model' => new User()]);
    }

    public function logout(Response $response)
    {
        $this->session->destroy();
        $response->redirect('/');
    }
}