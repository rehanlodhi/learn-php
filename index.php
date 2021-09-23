<?php
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

    ob_start();
    include __DIR__ . '/templates/' . $page['template'];
    $output = ob_get_clean();

} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
}

include __DIR__ . '/templates/layout.html.php';
