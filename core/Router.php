<?php
namespace app\core;

class Router {
    protected array $routes = [
        'get' => [],
        'post' => [],
        'put' => [],
        'delete' => []
    ];

    public Request $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function get($path, $callback): void {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback): void {
        $this->routes['post'][$path] = $callback;
    }

    public function put($path, $callback): void {
        $this->routes['put'][$path] = $callback;
    }

    public function delete($path, $callback): void {
        $this->routes['delete'][$path] = $callback;
    }

    public function resolve() {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            throw new \Exception("Route not found", 404);
        }

        if (is_string($callback)) {
            return Template::view($callback);
        }

        if (is_array($callback)) {
            $controller = new $callback[0]();
            $action = $callback[1];
            return call_user_func([$controller, $action], $this->request);
        }

        return call_user_func($callback, $this->request);
    }
}