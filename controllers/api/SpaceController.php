<?php
namespace app\controllers\api;

use app\core\Controller;
use app\services\SpaceService;

class SpaceController extends Controller {
    private SpaceService $spaceService;

    public function __construct() {
        $this->spaceService = new SpaceService();
        header('Content-Type: application/json');
    }

    public function index() {
        $spaces = $this->spaceService->getAvailableSpaces();
        echo json_encode($spaces);
    }

    public function featured() {
        $spaces = array_slice($this->spaceService->getAvailableSpaces(), 0, 3);
        echo json_encode($spaces);
    }

    public function show(int $id) {
        $space = $this->spaceService->getSpaceById($id);
        echo json_encode($space);
    }

    public function store() {
        $data = $_POST;
        $imagePath = $this->uploadImage($_FILES['image'] ?? null);

        $space = new \app\models\Space();
        $space->setName($data['name']);
        $space->setDescription($data['description']);
        $space->setPrice((float)$data['price']);
        $space->setLocation($data['location']);
        $space->setAvailability((bool)$data['availability']);
        $space->setImage($imagePath);

        $createdSpace = $this->spaceService->createSpace($space);
        echo json_encode($createdSpace);
    }

    public function update(int $id) {
        parse_str(file_get_contents('php://input'), $data);
        $imagePath = $this->uploadImage($_FILES['image'] ?? null);

        $space = $this->spaceService->getSpaceById($id);
        $space->setName($data['name'] ?? $space->getName());
        $space->setDescription($data['description'] ?? $space->getDescription());
        $space->setPrice((float)($data['price'] ?? $space->getPrice()));
        $space->setLocation($data['location'] ?? $space->getLocation());
        $space->setAvailability((bool)($data['availability'] ?? $space->isAvailable()));
        if ($imagePath) $space->setImage($imagePath);

        $updatedSpace = $this->spaceService->updateSpace($space);
        echo json_encode($updatedSpace);
    }

    public function destroy(int $id) {
        $this->spaceService->deleteSpace($id);
        http_response_code(204);
    }

    private function uploadImage(?array $file): ?string {
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $uploadDir = PROJECT_ROOT . '/public/uploads/';
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $extension;
        move_uploaded_file($file['tmp_name'], $uploadDir . $filename);

        return $filename;
    }
}