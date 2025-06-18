<?php

namespace app\controllers;

use app\core\Controller;
use app\mappers\BookingMapper;
use app\mappers\ReviewMapper;

class DashboardController extends Controller
{
    public function index()
    {
        if (!$this->session->get('user_id')) {
            $this->session->setFlash('error', 'Пожалуйста, войдите в систему');
            return (new Response())->redirect('/login');
        }

        $bookingMapper = new BookingMapper();
        $bookings = $bookingMapper->findByUser($this->session->get('user_id'));

        $reviewMapper = new ReviewMapper();
        $reviews = $reviewMapper->findByUser($this->session->get('user_id'));

        return $this->render('dashboard/index', [
            'bookings' => $bookings,
            'reviews' => $reviews
        ]);
    }
}