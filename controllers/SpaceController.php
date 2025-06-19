<?php
namespace app\controllers;

use app\core\Controller;
use app\services\SpaceService;

class SpaceController extends Controller {
    private SpaceService $spaceService;

    public function __construct() {
        $this->spaceService = new SpaceService();
    }

    public function index() {
        $spaces = $this->spaceService->getAvailableSpaces();
        return $this->render('spaces/index', ['spaces' => $spaces]);
    }
}