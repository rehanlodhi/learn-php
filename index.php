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
    include __DIR__ . '/includes/controllers/JokeController.php';

    $jokesTable = new Database($pdo, 'joke', 'id');
    $authorsTable = new Database($pdo, 'joke', 'id');
    $jokeController = new JokeController($jokesTable, $authorsTable);

    $action = $_GET['action'] ?? 'home';

    $page = $jokeController->$action();

    $title = $page['title'];

    if( isset($page['variables']) ){
      $output = loadTemplate($page['template'], $page['variables']);
    }else {
      $output = loadTemplate( $page['template']);
    }

} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
}

include __DIR__ . '/templates/layout.html.php';
