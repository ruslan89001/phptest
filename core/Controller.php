<?php
namespace app\core;

class Controller {
    public function render($view, $params = []) {
        return Template::View($view, $params);
    }

    protected function redirect($url) {
        header("Location: $url");
        exit();
    }
}