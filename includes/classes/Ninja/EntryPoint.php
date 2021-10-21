<?php

namespace Ninja;

class EntryPoint
{

    private $route;
    private $method;
    private $routes;

    public function __construct(string $route, string $method, \Ijdb\Routes $routes)
    {
        $this->route = $route;
        $this->routes = $routes;
        $this->method = $method;
        $this->checkUrl();
    }

    private function checkUrl()
    {
        if ($this->route !== strtolower($this->route)) {
            http_responce_code(301);
            header('location: index.php?route=' . strtolower($route));
        }
    }

    private function loadTemplate($templateFileName, $variables = [])
    {
        extract($variables);
        ob_start();
        include $_SERVER['DOCUMENT_ROOT'] . '/learn-php/templates/' . $templateFileName;
        return ob_get_clean();
    }

    public function run()
    {
        $routes = $this->routes->getRoutes();
        $controller = $routes[$this->route][$this->method]['controller'];
        $action = $routes[$this->route][$this->method]['action'];

        $page = $controller->$action();
        $title = $page['title'];

        if (isset($page['variables'])) {
            $output = $this->loadTemplate($page['template'], $page['variables']);
        } else {
            $output = $this->loadTemplate($page['template']);
        }
        include dirname(__DIR__) . '/../../templates/layout.html.php';
    }
}
