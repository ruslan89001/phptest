<?php
namespace app\services;

use app\mappers\UserMapper;
use app\models\User;

class AuthService {
    private UserMapper $userMapper;

    public function __construct() {
        $this->userMapper = new UserMapper();
    }

    public function register(User $user): User {
        $existingUser = $this->userMapper->findByEmail($user->getEmail());
        if ($existingUser) {
            throw new \RuntimeException('Email already exists');
        }

        $userId = $this->userMapper->save($user);
        return $this->userMapper->findById($userId);
    }

    public function login(string $email, string $password): ?User {
        $user = $this->userMapper->findByEmail($email);
        if ($user && password_verify($password, $user->getPassword())) {
            return $user;
        }
        return null;
    }
}