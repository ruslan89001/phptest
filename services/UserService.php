<?php
namespace app\services;

use app\mappers\UserMapper;
use app\models\User;

class UserService {
    private UserMapper $mapper;

    public function __construct() {
        $this->mapper = new UserMapper();
    }

    public function getAllUsers(): array {
        return $this->mapper->findAll();
    }

    public function getUserById(int $id): ?User {
        return $this->mapper->findById($id);
    }

    public function updateUser(User $user): User {
        $this->mapper->update($user);
        return $this->mapper->findById($user->getId());
    }

    public function deleteUser(int $id): void {
        $this->mapper->delete($id);
    }
}