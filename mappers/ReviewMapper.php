<?php

namespace app\mappers;

use app\core\Database;
use app\models\Review;
use PDO;

class ReviewMapper
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function findBySpace(int $spaceId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT r.*, u.username 
            FROM reviews r
            JOIN users u ON r.user_id = u.id
            WHERE r.space_id = :space_id
            ORDER BY r.created_at DESC
        ");
        $stmt->execute(['space_id' => $spaceId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByUser(int $userId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT r.*, s.name AS space_name 
            FROM reviews r
            JOIN spaces s ON r.space_id = s.id
            WHERE r.user_id = :user_id
            ORDER BY r.created_at DESC
        ");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save(Review $review): bool
    {
        $sql = "INSERT INTO reviews (user_id, space_id, rating, comment) 
                VALUES (:user_id, :space_id, :rating, :comment)";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'user_id' => $review->user_id,
            'space_id' => $review->space_id,
            'rating' => $review->rating,
            'comment' => $review->comment
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM reviews WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function getAverageRating(int $spaceId): float
    {
        $stmt = $this->pdo->prepare("
            SELECT AVG(rating) AS average 
            FROM reviews 
            WHERE space_id = :space_id
        ");
        $stmt->execute(['space_id' => $spaceId]);
        return (float)$stmt->fetchColumn();
    }
    public function getCount(): int
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM reviews");
        return (int)$stmt->fetchColumn();
    }
}