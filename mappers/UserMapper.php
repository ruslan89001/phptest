<?php
namespace app\mappers;

use app\core\BaseMapper;
use app\models\User;
use PDO;

class UserMapper extends BaseMapper {
    protected function getTableName(): string {
        return 'users';
    }

    protected function mapToEntity(array $data): User {
        $user = new User();
        $user->setId($data['id']);
        $user->setUsername($data['username']);
        $user->setEmail($data['email']);
        $user->setRole($data['role']);
        $user->setToken($data['token']);
        return $user;
    }

    public function findByEmail(string $email): ?User {
        $sql = "SELECT * FROM {$this->getTableName()} WHERE email = :email";
        $stmt = $this->db->query($sql, ['email' => $email]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? $this->mapToEntity($data) : null;
    }

    public function save(User $user): int {
        $sql = "INSERT INTO {$this->getTableName()} 
                (username, email, password, role, token) 
                VALUES (:username, :email, :password, :role, :token)";
        return $this->executeInsert($sql, [
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'role' => $user->getRole(),
            'token' => $user->getToken()
        ]);
    }
}