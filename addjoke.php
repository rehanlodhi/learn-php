<?php
if (isset($_POST['joketext']) && !empty($_POST['joketext'])):
    try {
        include __DIR__ . '/includes/DatabaseConnection.php';
        include __DIR__ . '/includes/DatabaseFunctions.php';

        insertJoke($pdo, $_POST['joketext'], 1);

        header('location: jokes.php');

    } catch (PDOException $e){
        $title = 'An error has occurred';
        $output = 'Database error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
    }
else:
    $title = 'Add New Joke';
    ob_start();
    include __DIR__ . '/templates/addjoke.html.php';
    $output = ob_get_clean();
endif;
include __DIR__ . '/templates/layout.html.php';