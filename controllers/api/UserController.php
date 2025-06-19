<?php
namespace app\controllers\api;

use app\core\Controller;
use app\services\UserService;

class UserController extends Controller {
    private UserService $userService;

    public function __construct() {
        $this->userService = new UserService();
        header('Content-Type: application/json');
    }

    public function index() {
        $users = $this->userService->getAllUsers();
        echo json_encode($users);
    }

    public function show(int $id) {
        $user = $this->userService->getUserById($id);
        echo json_encode($user);
    }

    public function update(int $id) {
        parse_str(file_get_contents('php://input'), $data);

        $user = $this->userService->getUserById($id);
        $user->setUsername($data['username']);
        $user->setEmail($data['email']);
        $user->setRole($data['role']);
        if (!empty($data['password'])) {
            $user->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));
        }

        $updatedUser = $this->userService->updateUser($user);
        echo json_encode($updatedUser);
    }

    public function destroy(int $id) {
        $this->userService->deleteUser($id);
        http_response_code(204);
    }
}