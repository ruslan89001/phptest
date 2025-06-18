<?php

namespace app\models;

use app\core\Model;

class Review extends Model
{
    public ?int $id = null;
    public int $user_id;
    public int $space_id;
    public int $rating;
    public string $comment = '';
    public string $created_at = '';

    public function rules(): array
    {
        return [
            'user_id' => [self::RULE_REQUIRED],
            'space_id' => [self::RULE_REQUIRED],
            'rating' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 1], [self::RULE_MAX, 'max' => 5]],
            'comment' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 10]]
        ];
    }
}