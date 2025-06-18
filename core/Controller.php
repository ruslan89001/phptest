<?php

namespace app\core;

use app\core\Template;
use app\core\Application;

abstract class Controller
{
    protected Request $request;
    protected Response $response;
    protected Session $session;

    public function __construct()
    {
        $this->request = Application::$app->request;
        $this->response = Application::$app->response;
        $this->session = Application::$app->session;
    }

    protected function render(string $view, array $params = [])
    {
        Template::setCachePath(Application::$ROOT_DIR . '/cache/');
        Template::setTemplatePath(Application::$ROOT_DIR . '/app/views/');
        Template::setCacheEnabled(Application::$app->config['app']['env'] === 'production');

        $params['session'] = $this->session;
        $params['app'] = Application::$app;

        Template::View($view, $params);
    }

    protected function redirect(string $url)
    {
        $this->response->redirect($url);
    }

    protected function isAdmin(): bool
    {
        return $this->session->get('user_role') === 'admin';
    }
}