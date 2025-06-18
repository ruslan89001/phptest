<?php

namespace app\mappers;

use app\core\Database;
use app\models\Booking;
use PDO;

class BookingMapper
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function findByUser(int $userId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT b.*, s.name AS space_name 
            FROM bookings b
            JOIN spaces s ON b.space_id = s.id
            WHERE b.user_id = :user_id
            ORDER BY b.start_time DESC
        ");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save(Booking $booking): bool
    {
        if ($booking->id) {
            return $this->update($booking);
        }
        return $this->insert($booking);
    }

    private function insert(Booking $booking): bool
    {
        $sql = "INSERT INTO bookings (user_id, space_id, start_time, end_time, status) 
                VALUES (:user_id, :space_id, :start_time, :end_time, :status)";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'user_id' => $booking->user_id,
            'space_id' => $booking->space_id,
            'start_time' => $booking->start_time,
            'end_time' => $booking->end_time,
            'status' => $booking->status
        ]);
    }

    private function update(Booking $booking): bool
    {
        $sql = "UPDATE bookings SET 
                start_time = :start_time, 
                end_time = :end_time, 
                status = :status
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            'id' => $booking->id,
            'start_time' => $booking->start_time,
            'end_time' => $booking->end_time,
            'status' => $booking->status
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM bookings WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function checkAvailability(int $spaceId, string $startTime, string $endTime): bool
    {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) 
            FROM bookings 
            WHERE space_id = :space_id 
            AND NOT (
                end_time <= :start_time OR 
                start_time >= :end_time
            )
        ");

        $stmt->execute([
            'space_id' => $spaceId,
            'start_time' => $startTime,
            'end_time' => $endTime
        ]);

        return $stmt->fetchColumn() === 0;
    }
    public function getCount(): int
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM bookings");
        return (int)$stmt->fetchColumn();
    }
}