<?php
namespace app\core;

class Request {
    public function getPath() {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        return $position === false ? $path : substr($path, 0, $position);
    }

    public function getMethod() {
        $method = strtolower($_SERVER['REQUEST_METHOD']);

        if ($method === 'post' && isset($_POST['_method'])) {
            return strtolower($_POST['_method']);
        }

        return $method;
    }

    public function getBody() {
        $body = [];
        $method = $this->getMethod();

        if ($method === 'get') {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($method === 'post' || $method === 'put' || $method === 'delete') {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }

            if (empty($body)) {
                $input = file_get_contents('php://input');
                if (!empty($input)) {
                    parse_str($input, $body);
                }
            }
        }

        return $body;
    }
    private array $params = [];

    public function setParams(array $params): void {
        $this->params = $params;
    }

    public function getParam(int $index) {
        return $this->params[$index] ?? null;
    }
}