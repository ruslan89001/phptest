<?php

namespace app\core;

class Application
{
    public static string $ROOT_DIR;
    public static Application $app;

    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public Database $db;
    public array $config;

    public function __construct(string $rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;

        $this->config = $config;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->session = new Session();

        $this->db = Database::getInstance($config['db']);

        if ($this->config['app']['env'] !== 'production') {
            $this->db->applyMigrations();
        }

        Template::setCachePath($rootPath . '/cache/');
        Template::setTemplatePath($rootPath . '/app/views/');
        Template::setCacheEnabled($this->config['app']['env'] === 'production');
    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            $this->response->setStatusCode($e->getCode());
            $this->render('error', [
                'exception' => $e
            ]);
        }
    }

    public function render(string $view, array $params = [])
    {
        $params['session'] = $this->session;
        $params['app'] = $this;

        Template::View($view . '.html', $params);
    }
}