<?php
namespace app\services;

use app\mappers\BookingMapper;
use app\models\Booking;

class BookingService {
    private BookingMapper $mapper;

    public function __construct() {
        $this->mapper = new BookingMapper();
    }

    public function getAllBookings(): array {
        return $this->mapper->findAll();
    }

    public function getUserBookings(int $userId): array {
        return $this->mapper->findByUser($userId);
    }

    public function getBookingById(int $id): ?Booking {
        return $this->mapper->findById($id);
    }

    public function createBooking(Booking $booking): Booking {
        $bookingId = $this->mapper->save($booking);
        return $this->mapper->findById($bookingId);
    }

    public function updateBooking(Booking $booking): Booking {
        $this->mapper->update($booking);
        return $this->mapper->findById($booking->getId());
    }

    public function deleteBooking(int $id): void {
        $this->mapper->delete($id);
    }
}