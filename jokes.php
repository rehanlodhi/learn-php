<?php
try {
    include __DIR__ . '/includes/DatabaseConnection.php';
    include_once __DIR__ . '/includes/DatabaseFunctions.php';


    $jokes = getAllJokes($pdo);
    $title = 'Joke list';
    $totalJokes = totalJokes($pdo);
    ob_start();
    include __DIR__ . '/templates/jokes.html.php';
    $output = ob_get_clean();
} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage() . ' in '
        . $e->getFile() . ':' . $e->getLine();
}
include __DIR__ . '/templates/layout.html.php';