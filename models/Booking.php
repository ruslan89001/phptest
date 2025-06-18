<?php

namespace app\models;

use app\core\Model;

class Booking extends Model
{
    public ?int $id = null;
    public int $user_id;
    public int $space_id;
    public string $start_time;
    public string $end_time;
    public string $status = 'pending';
    public string $created_at = '';
    public string $updated_at = '';

    public function rules(): array
    {
        return [
            'user_id' => [self::RULE_REQUIRED],
            'space_id' => [self::RULE_REQUIRED],
            'start_time' => [self::RULE_REQUIRED],
            'end_time' => [self::RULE_REQUIRED]
        ];
    }
}