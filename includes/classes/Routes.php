<?php

class Routes {
  public function callAction($routes) {
    include dirname(__DIR__) . '/DatabaseConnection.php';
    include dirname(__DIR__) . '/classes/Database.php';

    $jokesTable = new Database($pdo, 'joke', 'id');
    $authorsTable = new Database($pdo, 'joke', 'id');

    if ( $routes === 'list' ) {
        include dirname(__DIR__) . '/controllers/jokeController.php';
        $controller = new JokeController($jokesTable, $authorsTable);
        $page = $controller->list();
    } else if ( $routes === 'home' ) {
        include dirname(__DIR__) . '/controllers/jokeController.php';
        $controller = new JokeController($jokesTable, $authorsTable);
        $page = $controller->home();
    } else if ( $routes === 'edit' ) {
        include dirname(__DIR__) . '/controllers/jokeController.php';
        $controller = new JokeController($jokesTable, $authorsTable);
        $page = $controller->edit();
    } else if ( $routes === 'delete' ) {
        include dirname(__DIR__) . '/controllers/jokeController.php';
        $controller = new JokeController($jokesTable, $authorsTable);
        $page = $controller->delete();
    } else if ( $routes === 'register' ) {
        include dirname(__DIR__) . '/controllers/RegisterController.php';
        $controller = new RegisterController($authorsTable);
        $page = $controller->showForm();
    }
  return $page;
  }
}
