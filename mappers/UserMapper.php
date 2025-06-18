<?php

namespace app\mappers;

use app\core\Database;
use app\models\User;
use PDO;

class UserMapper
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function findById(int $id): ?User
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, User::class);
        return $stmt->fetch() ?: null;
    }

    public function findByEmail(string $email): ?User
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, User::class);
        return $stmt->fetch() ?: null;
    }

    public function save(User $user): bool
    {
        if ($user->id) {
            return $this->update($user);
        }
        return $this->insert($user);
    }

    private function insert(User $user): bool
    {
        $sql = "INSERT INTO users (username, password, email, role) 
                VALUES (:username, :password, :email, :role)";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'username' => $user->username,
            'password' => password_hash($user->password, PASSWORD_DEFAULT),
            'email' => $user->email,
            'role' => $user->role
        ]);
    }

    private function update(User $user): bool
    {
        $sql = "UPDATE users SET 
                username = :username, 
                password = :password, 
                email = :email, 
                role = :role,
                token = :token
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id' => $user->id,
            'username' => $user->username,
            'password' => $user->password ? password_hash($user->password, PASSWORD_DEFAULT) : $user->password,
            'email' => $user->email,
            'role' => $user->role,
            'token' => $user->token
        ]);
    }

    public function verifyPassword(User $user, string $password): bool
    {
        return password_verify($password, $user->password);
    }
    public function getCount(): int
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM users");
        return (int)$stmt->fetchColumn();
    }
}