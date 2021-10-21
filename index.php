<?php

try {
    include __DIR__ . '/includes/autoload.php';

    $route = $_GET['route'] ?? 'home';

    $entryPoint = new \Ninja\EntryPoint($route, $_SERVER['REQUEST_METHOD'], new \Ijdb\Routes());
    $entryPoint->run();

} catch (PDOException $e) {
    $title = 'An error has occurred';
    $output = 'Database error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
    include __DIR__ . '/templates/layout.html.php';
}
