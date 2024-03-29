<?php

try {
    include __DIR__ . '/includes/DatabaseConnection.php';
    include __DIR__ . '/includes/classes/Database.php';

    $jokesTable = new Database($pdo, 'joke', 'id');

    if (isset($_POST['joke'])){

        $joke = $_POST['joke'];
        $joke['authorid'] = 1;
        $joke['jokedate'] = new DateTime();

        $jokesTable->save($joke);

        header('location: jokes.php');
    } else{
        if (isset($_GET['id'])){
            $joke = $jokesTable->findById($_GET['id']);
        }

       $title = 'Edit Joke';
       ob_start();
       include __DIR__ . '/templates/editjoke.html.php';
       $output = ob_get_clean();
    }
} catch (PDOException $e){
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage() . 'in ' . $e->getFile() . ':' . $e->getLine();
}
include __DIR__ . '/templates/layout.html.php';