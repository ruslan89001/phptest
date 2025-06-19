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
        $featuredSpaces = array_slice($this->spaceService->getAvailableSpaces(), 0, 3);
        return $this->render('home', [
            'featuredSpaces' => $featuredSpaces
        ]);
    }
}