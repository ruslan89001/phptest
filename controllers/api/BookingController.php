<?php
namespace app\controllers\api;

use app\core\Controller;
use app\services\BookingService;

class BookingController extends Controller {
    private BookingService $bookingService;

    public function __construct() {
        $this->bookingService = new BookingService();
        header('Content-Type: application/json');
    }

    public function index() {
        $bookings = $this->bookingService->getAllBookings();
        echo json_encode($bookings);
    }

    public function userBookings() {
        if (!isset($_SESSION['user'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $bookings = $this->bookingService->getUserBookings($_SESSION['user']->getId());
        echo json_encode($bookings);
    }

    public function store() {
        $data = json_decode(file_get_contents('php://input'), true);

        $booking = new \app\models\Booking();
        $booking->setUserId($_SESSION['user']->getId());
        $booking->setSpaceId($data['space_id']);
        $booking->setStartTime(new \DateTime($data['start_time']));
        $booking->setEndTime(new \DateTime($data['end_time']));
        $booking->setStatus('pending');

        $createdBooking = $this->bookingService->createBooking($booking);
        echo json_encode($createdBooking);
    }

    public function updateStatus(int $id) {
        $data = json_decode(file_get_contents('php://input'), true);
        $booking = $this->bookingService->getBookingById($id);
        $booking->setStatus($data['status']);

        $updatedBooking = $this->bookingService->updateBooking($booking);
        echo json_encode($updatedBooking);
    }

    public function destroy(int $id) {
        $this->bookingService->deleteBooking($id);
        http_response_code(204);
    }
}