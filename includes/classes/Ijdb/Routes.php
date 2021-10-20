<?php
namespace Ijdb;

class Routes {
  public function callAction($routes) {
    include dirname(__DIR__) . '/../DatabaseConnection.php';

    $jokesTable = new \Ninja\Database($pdo, 'joke', 'id');
    $authorsTable = new \Ninja\Database($pdo, 'joke', 'id');

    if ( $routes === 'list' ) {
        $controller = new \Ijdb\Controllers\Joke($jokesTable, $authorsTable);
        $page = $controller->list();
    } else if ( $routes === 'home' ) {
        $controller = new \Ijdb\Controllers\Joke($jokesTable, $authorsTable);
        var_dump($controller);

        $page = $controller->home();
    } else if ( $routes === 'edit' ) {
        $controller = new \Ijdb\Controllers\Joke($jokesTable, $authorsTable);
        $page = $controller->edit();
    } else if ( $routes === 'delete' ) {
        $controller = new \Ijdb\Controllers\Joke($jokesTable, $authorsTable);
        $page = $controller->delete();
    } else if ( $routes === 'register' ) {
        $controller = new \Ijdb\Controllers\Joke($authorsTable);
        $page = $controller->showForm();
    }

  return $page;
  }
}
