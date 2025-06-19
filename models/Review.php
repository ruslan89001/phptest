<?php
namespace app\models;

class Review {
    private ?int $id = null;
    private int $userId;
    private int $spaceId;
    private int $rating;
    private ?string $comment;
    private \DateTime $createdAt;
    private ?string $username = null;

    public function getId(): ?int { return $this->id; }
    public function getUserId(): int { return $this->userId; }
    public function getSpaceId(): int { return $this->spaceId; }
    public function getRating(): int { return $this->rating; }
    public function getComment(): ?string { return $this->comment; }
    public function getCreatedAt(): \DateTime { return $this->createdAt; }
    public function getUsername(): ?string { return $this->username; }

    public function setId(int $id): void { $this->id = $id; }
    public function setUserId(int $userId): void { $this->userId = $userId; }
    public function setSpaceId(int $spaceId): void { $this->spaceId = $spaceId; }
    public function setRating(int $rating): void { $this->rating = $rating; }
    public function setComment(?string $comment): void { $this->comment = $comment; }
    public function setCreatedAt(\DateTime $createdAt): void { $this->createdAt = $createdAt; }
    public function setUsername(string $username): void { $this->username = $username; }
}