<?php
namespace Ninja;

class EntryPoint {

  private $route;
  private $routes;

  public function __construct ($route, $routes) {
    $this->route = $route;
    $this->routes = $routes;
    $this->checkUrl();
  }

  private function checkUrl() {
    if ($this->route !== strtolower($this->route)) {
      http_responce_code(301);
      header( 'location: index.php?route=' . strtolower($route) );
    }
  }

  private function loadTemplate($templateFileName, $variables = []){
    extract($variables);
    ob_start();
    include $_SERVER['DOCUMENT_ROOT'] . '/learn-php/templates/' . $templateFileName;
    return ob_get_clean();
  }

  public function run(){
    $page = $this->routes->callAction($this->route);
    $title = $page['title'];

    if( isset($page['variables']) ){
        $output = $this->loadTemplate($page['template'], $page['variables']);
    } else {
        $output = $this->loadTemplate( $page['template']);
    }
    include dirname(__DIR__) . '/../../templates/layout.html.php';
  }
}
