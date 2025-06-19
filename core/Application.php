<?php
namespace app\core;

class Application {
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Database $db;
    public static Application $app;

    public function __construct($rootPath) {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->router = new Router($this->request);
        $this->db = Database::getInstance();
    }

    public function run() {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            Logger::error("Error: " . $e->getMessage());

            try {
                if ($e->getCode() === 404) {
                    http_response_code(404);
                    echo Template::view('404.php');
                } else {
                    http_response_code(500);
                    echo Template::view('error.php', [
                        'message' => $e->getMessage(),
                        'code' => $e->getCode() ?: 500
                    ]);
                }
            } catch (\Exception $templateError) {
                die("Critical error: " . $templateError->getMessage());
            }
        }
    }
}