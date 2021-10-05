<?php
namespace Ijdb\Controllers
class Joke {
    private $jokesTable;
    private $authorsTable;

    public function __construct(Database $jokesTable, Database $authorsTable){
        $this->jokesTable = $jokesTable;
        $this->authorsTable = $authorsTable;
    }

    public function list(){
        $result = $this->jokesTable->findAll();
        $jokes = array();
        foreach ($result as $joke){
            $author = $this->authorsTable->findById($joke['authorid']);
            $jokes[] = [
                'id'       => $joke['id'],
                'joketext' => $joke['joketext'],
                'jokedate' => $joke['jokedate'],
                'name'     => $author['name'] ?? '',
                'email'    => $author['email'] ?? ''
            ];
        }
        $title = 'Joke list';
        $totalJokes = $this->jokesTable->total();
        return [
          'template' => 'jokes.html.php',
          'title' => $title,
          'variables' => [
              'jokes' => $jokes,
              'totalJokes' => $totalJokes
            ]
          ];
    }

    public function home(){
        $title = 'Internet Joke Database';
        return ['template' => 'home.html.php', 'title' => $title];
    }

    public function delete(){
        $this->jokesTable->delete($_POST['id']);
        header('location: index.php?action=list');
    }

    public function edit(){
        if (isset($_POST['joke'])){

            $joke = $_POST['joke'];
            $joke['authorid'] = 1;
            $joke['jokedate'] = new DateTime();

            $this->jokesTable->save($joke);

            header('location: index.php?action=list');
        } else{
            if (isset($_GET['id'])){
                $joke = $this->jokesTable->findById($_GET['id']);
            }

            $title = 'Edit Joke';
            return [
              'template' => 'editjoke.html.php',
              'title' => $title,
              'variables' => [
                'joke' => $joke ?? null
              ]
            ];
        }
    }
}
