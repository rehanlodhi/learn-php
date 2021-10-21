<?php
try {
    include __DIR__ . '/includes/DatabaseConnection.php';
    //include __DIR__ . '/includes/classes/Database.php';

    $jokesTable = new Database($pdo, 'joke', 'id');
    $jokesTable->delete($_POST['id']);
    header('location: jokes.php');
} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage() . ' in '
        . $e->getFile() . ':' . $e->getLine();
}
include __DIR__ . '/templates/layout.html.php';