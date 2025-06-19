<?php
namespace app\controllers;

use app\core\Controller;
use app\models\Booking;
use app\services\BookingService;

class BookingController extends Controller {
    private BookingService $bookingService;

    public function __construct() {
        $this->bookingService = new BookingService();
    }

    public function index() {
        if (!isset($_SESSION['user'])) {
            $this->redirect('/login');
        }
        $bookings = $this->bookingService->getUserBookings($_SESSION['user']->getId());
        return $this->render('bookings/index', ['bookings' => $bookings]);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $booking = new Booking();
            $booking->setUserId($_SESSION['user']->getId());
            $booking->setSpaceId($_POST['space_id']);
            $booking->setStartTime(new \DateTime($_POST['start_time']));
            $booking->setEndTime(new \DateTime($_POST['end_time']));
            $booking->setStatus('pending');

            $this->bookingService->createBooking($booking);
            $this->redirect('/bookings');
        }
    }
}