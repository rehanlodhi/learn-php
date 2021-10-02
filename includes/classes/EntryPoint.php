<?php

class EntryPoint {

  private $route;

  public function __construct ($route) {
    $this->route = $route;
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
    include dirname(__DIR__) . '/../templates/' . $templateFileName;
    return ob_get_clean();
  }

  private function callAction() {
    include dirname(__DIR__) . '/DatabaseConnection.php';
    include dirname(__DIR__) . '/classes/Database.php';

    $jokesTable = new Database($pdo, 'joke', 'id');
    $authorsTable = new Database($pdo, 'joke', 'id');

    if ( $this->route === 'list' ) {
        include dirname(__DIR__) . '/controllers/jokeController.php';
        $controller = new JokeController($jokesTable, $authorsTable);
        $page = $controller->list();
    } else if ( $this->route === 'home' ) {
        include dirname(__DIR__) . '/controllers/jokeController.php';
        $controller = new JokeController($jokesTable, $authorsTable);
        $page = $controller->home();
    } else if ( $this->route === 'edit' ) {
        include dirname(__DIR__) . '/controllers/jokeController.php';
        $controller = new JokeController($jokesTable, $authorsTable);
        $page = $controller->edit();
    } else if ( $this->route === 'delete' ) {
        include dirname(__DIR__) . '/controllers/jokeController.php';
        $controller = new JokeController($jokesTable, $authorsTable);
        $page = $controller->delete();
    } else if ( $this->route === 'register' ) {
        include dirname(__DIR__) . '/controllers/RegisterController.php';
        $controller = new RegisterController($authorsTable);
        $page = $controller->showForm();
  }
  return $page;
}

  public function run(){
    $page = $this->callAction();
    $title = $page['title'];

    if( isset($page['variables']) ){
        $output = $this->loadTemplate($page['template'], $page['variables']);
    } else {
        $output = $this->loadTemplate( $page['template']);
    }

    include dirname(__DIR__) . '/../templates/layout.html.php';
  }
}
