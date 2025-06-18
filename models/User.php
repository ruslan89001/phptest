<?php

namespace app\models;

use app\core\Model;

class User extends Model
{
    public ?int $id = null;
    public string $username = '';
    public string $password = '';
    public string $email = '';
    public string $role = 'user';
    public ?string $token = null;
    public string $created_at = '';
    public string $updated_at = '';

    public function rules(): array
    {
        return [
            'username' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 3]],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 6]]
        ];
    }
}