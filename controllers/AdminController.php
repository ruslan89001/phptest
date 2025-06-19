<?php
namespace app\controllers;

use app\core\Controller;
use app\mappers\BookingMapper;
use app\mappers\SpaceMapper;
use app\mappers\UserMapper;

class AdminController extends Controller {
    public function viewUsers() {
        $mapper = new UserMapper();
        $users = $mapper->findAll();
        return $this->render('admin/users', ['users' => $users]);
    }

    public function viewSpaces() {
        $mapper = new SpaceMapper();
        $spaces = $mapper->findAll();
        return $this->render('admin/spaces', ['spaces' => $spaces]);
    }

    public function viewBookings() {
        $mapper = new BookingMapper();
        $bookings = $mapper->findAll();
        return $this->render('admin/bookings', ['bookings' => $bookings]);
    }
}