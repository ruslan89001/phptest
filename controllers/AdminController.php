<?php

namespace app\controllers;

use app\core\Controller;
use app\mappers\SpaceMapper;
use app\mappers\BookingMapper;
use app\mappers\UserMapper;
use app\mappers\ReviewMapper;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (!$this->isAdmin()) {
            $this->redirect('/login');
            return;
        }

        $spaceMapper = new SpaceMapper();
        $bookingMapper = new BookingMapper();
        $userMapper = new UserMapper();
        $reviewMapper = new ReviewMapper();

        $stats = [
            'spaces' => $spaceMapper->getCount(),
            'bookings' => $bookingMapper->getCount(),
            'users' => $userMapper->getCount(),
            'reviews' => $reviewMapper->getCount(),
        ];

        $this->render('admin/dashboard', [
            'stats' => $stats
        ]);
    }

    public function spaces()
    {
        if (!$this->isAdmin()) {
            $this->redirect('/login');
            return;
        }

        $mapper = new SpaceMapper();
        $spaces = $mapper->getAll();

        $this->render('admin/spaces/index', [
            'spaces' => $spaces
        ]);
    }

    public function createSpace()
    {
        if (!$this->isAdmin()) {
            $this->redirect('/login');
            return;
        }

        $this->render('admin/spaces/create');
    }

    public function storeSpace()
    {
        if (!$this->isAdmin()) {
            $this->redirect('/login');
            return;
        }

        // Реализация сохранения
        $this->redirect('/admin/spaces');
    }

    public function editSpace($id)
    {
        if (!$this->isAdmin()) {
            $this->redirect('/login');
            return;
        }

        $mapper = new SpaceMapper();
        $space = $mapper->getById($id);

        $this->render('admin/spaces/edit', [
            'space' => $space
        ]);
    }

    public function updateSpace($id)
    {
        if (!$this->isAdmin()) {
            $this->redirect('/login');
            return;
        }

        // Реализация обновления
        $this->redirect('/admin/spaces');
    }

    public function deleteSpace($id)
    {
        if (!$this->isAdmin()) {
            $this->redirect('/login');
            return;
        }

        $mapper = new SpaceMapper();
        $mapper->delete($id);
        $this->redirect('/admin/spaces');
    }
}