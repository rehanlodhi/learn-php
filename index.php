<?php
$title = 'Internet Joke Database';
ob_start();
include __DIR__ . '/templates/home.html.php';
$output = ob_get_clean();
include __DIR__ . '/templates/layout.html.php';


/*function insertJoke($pdo, $fields){
    $query = 'INSERT INTO `joke` SET';
    foreach ($fields as $key => $values){
        $query .= '`' . $key . '` = :' . $key;
    }

    echo $query;
}
insertJoke('ss', [
    'authorid' => 1,
    'joketext' => 'I am a one funny fucktard'
]);*/