<?php
try {
    include __DIR__ . '/includes/DatabaseConnection.php';
    //include_once __DIR__ . '/includes/classes/Database.php';

    //$jokes = getAllJokes($pdo); joke table able specific function
    $jokesTable = new Database($pdo, 'joke', 'id');
    $authorTable = new Database($pdo, 'author', 'id');

    $result = $jokesTable->findAll();

    $jokes = array();
    foreach ($result as $joke){
        $author = $authorTable->findById($joke['authorid']);
        $jokes[] = [
            'id' => $joke['id'],
            'joketext' => $joke['joketext'],
            'jokedate' => $joke['jokedate'],
            'name' => $author['name'],
            'email' => $author['email']
        ];
    }
    $title = 'Joke list';
    $totalJokes = $jokesTable->total();
    ob_start();
    include __DIR__ . '/templates/jokes.html.php';
    $output = ob_get_clean();
} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage() . ' in '
        . $e->getFile() . ':' . $e->getLine();
}
include __DIR__ . '/templates/layout.html.php';
