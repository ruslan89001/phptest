<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\mappers\BookingMapper;
use app\mappers\SpaceMapper;
use app\models\Booking;

class BookingController extends Controller
{
    public function create(Request $request, Response $response, int $spaceId)
    {
        $spaceMapper = new SpaceMapper();
        $space = $spaceMapper->findById($spaceId);

        if (!$space) {
            $this->session->setFlash('error', 'Пространство не найдено');
            $response->redirect('/spaces');
        }

        if ($request->isPost()) {
            $booking = new Booking();
            $booking->loadData($request->getBody());
            $booking->user_id = $this->session->get('user_id');
            $booking->space_id = $spaceId;
            $booking->status = 'pending';

            $bookingMapper = new BookingMapper();

            // Проверка доступности времени
            if (!$bookingMapper->checkAvailability($spaceId, $booking->start_time, $booking->end_time)) {
                $this->session->setFlash('error', 'Выбранное время недоступно');
                return $this->render('booking/create', [
                    'space' => $space,
                    'model' => $booking
                ]);
            }

            if ($bookingMapper->save($booking)) {
                $this->session->setFlash('success', 'Бронирование создано успешно!');
                $response->redirect('/bookings');
            } else {
                $this->session->setFlash('error', 'Ошибка при создании бронирования');
            }
        }

        return $this->render('booking/create', [
            'space' => $space,
            'model' => new Booking()
        ]);
    }

    public function index()
    {
        if (!$this->session->get('user_id')) {
            $this->session->setFlash('error', 'Пожалуйста, войдите в систему');
            return (new Response())->redirect('/login');
        }

        $bookingMapper = new BookingMapper();
        $bookings = $bookingMapper->findByUser($this->session->get('user_id'));

        return $this->render('booking/index', [
            'bookings' => $bookings
        ]);
    }

    public function cancel(Request $request, Response $response, int $id)
    {
        $bookingMapper = new BookingMapper();
        $booking = $bookingMapper->findById($id);

        if (!$booking || $booking['user_id'] !== $this->session->get('user_id')) {
            $this->session->setFlash('error', 'Бронирование не найдено');
            $response->redirect('/bookings');
        }

        if ($bookingMapper->delete($id)) {
            $this->session->setFlash('success', 'Бронирование отменено');
        } else {
            $this->session->setFlash('error', 'Ошибка при отмене бронирования');
        }

        $response->redirect('/bookings');
    }
}