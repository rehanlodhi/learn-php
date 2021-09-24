<?php

function loadTemplate( $templateFileName, $variables=[]) {

  extract($variables);

  ob_start();
  include __DIR__ . '/templates/' . $templateFileName;
  return ob_get_clean();
}
try {
    include __DIR__ . '/includes/DatabaseConnection.php';
    include __DIR__ . '/includes/classes/Database.php';

    $jokesTable = new Database($pdo, 'joke', 'id');
    $authorsTable = new Database($pdo, 'joke', 'id');

    $route = $_GET['route'] ?? 'joke/home';
    //$route = ltrim( strtok($_SERVER['REQUEST_URI'], '?'), '/' );
    //var_dump($routes);

    if ( $route == strtolower($route) ) {
      if ( $route === 'joke/list' ) {
          include __DIR__ . '/includes/controllers/jokeController.php';
          $controller = new JokeController($jokesTable, $authorsTable);
          $page = $controller->list();
      } else if ( $route === 'joke/home' ) {
          include __DIR__ . '/includes/controllers/jokeController.php';
          $controller = new JokeController($jokesTable, $authorsTable);
          $page = $controller->home();
      } else if ( $route === 'joke/edit' ) {
          include __DIR__ . '/includes/controllers/jokeController.php';
          $controller = new JokeController($jokesTable, $authorsTable);
          $page = $controller->edit();
      } else if ( $route === 'joke/delete' ) {
          include __DIR__ . '/includes/controllers/jokeController.php';
          $controller = new JokeController($jokesTable, $authorsTable);
          $page = $controller->delete();
      } else if ( $route === 'joke/register' ) {
          include __DIR__ . '/includes/controllers/RegisterController.php';
          $controller = new RegisterController($authorsTable);
          $page = $controller->showForm();
      }
    } else {
        http_responce_code(301);
        header( 'location: index.php?route=' . strtolower($route) );
    }

    $title = $page['title'];

    if( isset($page['variables']) ){
        $output = loadTemplate($page['template'], $page['variables']);
    } else {
        $output = loadTemplate( $page['template']);
    }

} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
}

include __DIR__ . '/templates/layout.html.php';
