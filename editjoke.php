<?php
include __DIR__ . '/includes/DatabaseConnection.php';
include __DIR__ . '/includes/DatabaseFunctions.php';

try {
    if (isset($_POST['joke'])){

        $joke = $_POST['joke'];
        $joke['authorid'] = 1;
        $joke['jokedate'] = new DateTime();

        save($pdo, 'joke', 'id', $joke);

       /* save($pdo, 'joke', 'id', [
            'id' => $_POST['jokeid'],
            'joketext' => $_POST['joketext'],
            'jokedate' => new DateTime(),
            'authorId' => 1
        ]);*/
        header('location: jokes.php');
    } else{
       //$joke = getJoke($pdo, $_GET['id']); old version, get one record
        if (isset($_GET['id'])){
            $joke = findById($pdo, 'joke', 'id', $_GET['id']);
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