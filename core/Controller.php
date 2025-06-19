<?php
namespace app\core;

class Controller {
    public function render($view, $params = []) {
        $content = $this->renderView($view, $params);

        return $this->renderLayout($content, $params);
    }

    protected function renderLayout($content, $params = []) {
        $layout = 'layouts/main';

        extract($params, EXTR_SKIP);

        ob_start();
        require self::getViewPath($layout);
        return ob_get_clean();
    }

    protected function renderView($view, $params = []) {
        extract($params, EXTR_SKIP);

        ob_start();
        require self::getViewPath($view);
        return ob_get_clean();
    }

    private static function getViewPath($view) {
        return PROJECT_ROOT . "/views/{$view}.php";
    }

    protected function redirect($url) {
        header("Location: $url");
        exit;
    }
}