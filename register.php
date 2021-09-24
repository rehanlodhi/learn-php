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
    include __DIR__ . '/includes/controllers/RegisterController.php';

    $jokesTable = new Database($pdo, 'joke', 'id');
    $authorsTable = new Database($pdo, 'joke', 'id');
    $registerController = new RegisterController($authorsTable);

    $action = $_GET['action'] ?? 'home';

    if ($action = strtolower($action)) {
      $page = $registerController->$action();
    }else {
      http_responce_code(301);
      header( 'location: index.php?action=' . strtolower($action) );
    }

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
