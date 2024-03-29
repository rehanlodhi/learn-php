
<?php

try {
    /*include __DIR__ . '/includes/classes/EntryPoint.php';
    include __DIR__ . '/includes/classes/Routes.php';*/

    include __DIR__ . '/includes/autoload.php';

    $route = $_GET['route'] ?? 'home';
    //$route = trim(strtok($_SERVER['REQUEST_URI'], '?'), '/learn-php/index.php');

    $entryPoint = new EntryPoint($route, new Routes());
    $entryPoint->run();

} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
    include __DIR__ . '/templates/layout.html.php';
}
