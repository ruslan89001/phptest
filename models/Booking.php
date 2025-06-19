<?php
namespace app\models;

class Booking {
    private ?int $id = null;
    private int $userId;
    private int $spaceId;
    private \DateTime $startTime;
    private \DateTime $endTime;
    private string $status;
    private ?string $spaceName = null;

    public function getId(): ?int { return $this->id; }
    public function getUserId(): int { return $this->userId; }
    public function getSpaceId(): int { return $this->spaceId; }
    public function getStartTime(): \DateTime { return $this->startTime; }
    public function getEndTime(): \DateTime { return $this->endTime; }
    public function getStatus(): string { return $this->status; }
    public function getSpaceName(): ?string { return $this->spaceName; }

    public function setId(int $id): void { $this->id = $id; }
    public function setUserId(int $userId): void { $this->userId = $userId; }
    public function setSpaceId(int $spaceId): void { $this->spaceId = $spaceId; }
    public function setStartTime(\DateTime $startTime): void { $this->startTime = $startTime; }
    public function setEndTime(\DateTime $endTime): void { $this->endTime = $endTime; }
    public function setStatus(string $status): void { $this->status = $status; }
    public function setSpaceName(string $spaceName): void { $this->spaceName = $spaceName; }
}