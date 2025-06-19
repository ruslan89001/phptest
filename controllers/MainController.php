<?php
namespace app\controllers;

use app\core\Controller;
use app\services\SpaceService;

class MainController extends Controller {
    private SpaceService $spaceService;

    public function __construct() {
        $this->spaceService = new SpaceService();
    }

    public function home() {
        $featuredSpaces = $this->spaceService->getFeaturedSpaces();
        return $this->render('home', [
            'title' => 'Главная страница',
            'user' => $_SESSION['user'] ?? null,
            'featuredSpaces' => $featuredSpaces
        ]);
    }
}