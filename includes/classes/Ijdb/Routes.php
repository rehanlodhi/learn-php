<?php

namespace Ijdb;

class Routes implements \Ninja\Routes
{
    public function getRoutes()
    {
        include dirname(__DIR__) . '/../DatabaseConnection.php';

        $jokesTable = new \Ninja\Database($pdo, 'joke', 'id');
        $authorsTable = new \Ninja\Database($pdo, 'author', 'id');

        $jokeController = new \Ijdb\Controllers\Joke($jokesTable, $authorsTable);
        $authorController = new \Ijdb\Controllers\Register($authorsTable);

        $routes = [
            'edit' => [
                'POST' => [
                    'controller' => $jokeController,
                    'action' => 'saveEdit'
                ],
                'GET' => [
                    'controller' => $jokeController,
                    'action' => 'edit'
                ]
            ],
            'delete' => [
                'GET' => [
                    'controller' => $jokeController,
                    'action' => 'delete'
                ]
            ],
            'list' => [
                'GET' => [
                    'controller' => $jokeController,
                    'action' => 'list'
                ]
            ],
            'home' => [
                'GET' => [
                    'controller' => $jokeController,
                    'action' => 'home'
                ]
            ],
            'register' => [
                'GET' => [
                    'controller' => $authorController,
                    'action' => 'registrationForm'
                ],
                'POST' => [
                    'controller' => $authorController,
                    'action' => 'registerUser'
                ]
            ],
            'registersuccess' => [
                'GET' => [
                    'controller' => $authorController,
                    'action' => 'success'
                ]
            ]
        ];

        return $routes;
    }
}
