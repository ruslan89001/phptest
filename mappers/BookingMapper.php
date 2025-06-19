<?php
namespace app\mappers;

use app\core\BaseMapper;
use app\models\Booking;
use PDO;

class BookingMapper extends BaseMapper {
    protected function getTableName(): string {
        return 'bookings';
    }

    protected function mapToEntity(array $data): Booking {
        $booking = new Booking();
        $booking->setId($data['id']);
        $booking->setUserId($data['user_id']);
        $booking->setSpaceId($data['space_id']);
        $booking->setStartTime(new \DateTime($data['start_time']));
        $booking->setEndTime(new \DateTime($data['end_time']));
        $booking->setStatus($data['status']);
        return $booking;
    }

    public function findByUser(int $userId): array {
        $sql = "SELECT b.*, s.name as space_name FROM {$this->getTableName()} b
                JOIN spaces s ON b.space_id = s.id
                WHERE b.user_id = :user_id";
        $stmt = $this->db->query($sql, ['user_id' => $userId]);
        return array_map([$this, 'mapToEntity'], $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function save(Booking $booking): int {
        $sql = "INSERT INTO {$this->getTableName()} 
                (user_id, space_id, start_time, end_time, status) 
                VALUES (:user_id, :space_id, :start_time, :end_time, :status)";
        return $this->executeInsert($sql, [
            'user_id' => $booking->getUserId(),
            'space_id' => $booking->getSpaceId(),
            'start_time' => $booking->getStartTime()->format('Y-m-d H:i:s'),
            'end_time' => $booking->getEndTime()->format('Y-m-d H:i:s'),
            'status' => $booking->getStatus()
        ]);
    }

    public function findAll(): array {
        $sql = "SELECT b.*, s.name as space_name, u.username 
            FROM {$this->getTableName()} b
            JOIN spaces s ON b.space_id = s.id
            JOIN users u ON b.user_id = u.id";
        $stmt = $this->db->query($sql);
        return array_map([$this, 'mapToEntity'], $stmt->fetchAll(PDO::FETCH_ASSOC));
    }
}