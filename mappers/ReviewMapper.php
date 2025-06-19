<?php
namespace app\mappers;

use app\core\BaseMapper;
use app\models\Review;
use PDO;

class ReviewMapper extends BaseMapper {
    protected function getTableName(): string {
        return 'reviews';
    }

    protected function mapToEntity(array $data): Review {
        $review = new Review();
        $review->setId($data['id']);
        $review->setUserId($data['user_id']);
        $review->setSpaceId($data['space_id']);
        $review->setRating($data['rating']);
        $review->setComment($data['comment']);
        $review->setCreatedAt(new \DateTime($data['created_at']));
        return $review;
    }

    public function findBySpace(int $spaceId): array {
        $sql = "SELECT r.*, u.username FROM {$this->getTableName()} r
                JOIN users u ON r.user_id = u.id
                WHERE r.space_id = :space_id";
        $stmt = $this->db->query($sql, ['space_id' => $spaceId]);
        return array_map([$this, 'mapToEntity'], $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function save(Review $review): int {
        $sql = "INSERT INTO {$this->getTableName()} 
                (user_id, space_id, rating, comment) 
                VALUES (:user_id, :space_id, :rating, :comment)";
        return $this->executeInsert($sql, [
            'user_id' => $review->getUserId(),
            'space_id' => $review->getSpaceId(),
            'rating' => $review->getRating(),
            'comment' => $review->getComment()
        ]);
    }

    public function findAll(): array {
        $sql = "SELECT r.*, u.username, s.name as space_name 
            FROM {$this->getTableName()} r
            JOIN users u ON r.user_id = u.id
            JOIN spaces s ON r.space_id = s.id";
        $stmt = $this->db->query($sql);
        return array_map([$this, 'mapToEntity'], $stmt->fetchAll(PDO::FETCH_ASSOC));
    }
}