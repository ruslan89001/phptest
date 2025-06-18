<?php

namespace app\models;

use app\core\Model;

class Space extends Model
{
    public ?int $id = null;
    public string $name = '';
    public string $description = '';
    public float $price = 0.0;
    public bool $availability = true;
    public string $location = '';
    public ?string $image = null;
    public string $created_at = '';
    public string $updated_at = '';

    public function rules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 3]],
            'description' => [self::RULE_REQUIRED],
            'price' => [self::RULE_REQUIRED, self::RULE_NUMBER],
            'location' => [self::RULE_REQUIRED]
        ];
    }

    public function attributes(): array
    {
        return ['name', 'description', 'price', 'availability', 'location', 'image'];
    }

    public function getFormattedPrice(): string
    {
        return number_format($this->price, 2) . ' ₽/час';
    }

    public function getStatusBadge(): string
    {
        return $this->availability
            ? '<span class="badge bg-success">Доступно</span>'
            : '<span class="badge bg-danger">Недоступно</span>';
    }
}