<?php
namespace app\models;

class Space {
    private ?int $id = null;
    private string $name;
    private string $description;
    private float $price;
    private bool $availability;
    private string $location;
    private ?string $image = null;

    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getDescription(): string { return $this->description; }
    public function getPrice(): float { return $this->price; }
    public function isAvailable(): bool { return $this->availability; }
    public function getLocation(): string { return $this->location; }
    public function getImage(): ?string { return $this->image; }

    public function setId(int $id): void { $this->id = $id; }
    public function setName(string $name): void { $this->name = $name; }
    public function setDescription(string $description): void { $this->description = $description; }
    public function setPrice(float $price): void { $this->price = $price; }
    public function setAvailability(bool $availability): void { $this->availability = $availability; }
    public function setLocation(string $location): void { $this->location = $location; }
    public function setImage(?string $image): void { $this->image = $image; }
}