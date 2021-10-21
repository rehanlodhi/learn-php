<?php

namespace Ijdb\Controllers;

use Ninja\Database;

class Register
{
    private $authorTable;

    public function __construct(Database $authorTable)
    {
        $this->authorTable = $authorTable;
    }

    public function registrationForm()
    {
        return ['template' => 'register.html.php', 'title' => 'Register an account'];
    }

    public function success()
    {
        return ['template' => 'registersuccess.html.php', 'title' => 'Registration Successful'];
    }

    public function registerUser()
    {
        $author = $_POST['author'];
        $valid = true;
        $errors = array();

        if (empty($author['name'])) {
            $valid = false;
            $errors[] = 'Name cannot be empty';
        }
        if (empty($author['email'])) {
            $valid = false;
            $errors[] = 'Email cannot be empty';
        } else if (filter_var($author['email'], FILTER_VALIDATE_EMAIL) == false) {
            $valid = false;
            $errors[] = 'Enter valid email';
        } else {
            $author['email'] = strtolower($author['email']);
            if (count($this->authorTable->find('email', $author['email'])) > 0 ){
                $valid = false;
                $errors[] = 'This email address is already registered';
            }
        }
        if (empty($author['password'])) {
            $valid = false;
            $errors[] = 'Password cannot be empty';
        }

        if ($valid == true) {
            $author['password'] = password_hash($author['password'], PASSWORD_DEFAULT);
            $this->authorTable->save($author);
            header('Location: http://localhost:8888/learn-php/index.php?route=registersuccess');
        } else {
            return [
                'template' => 'register.html.php',
                'title' => '',
                'variables' => [
                    'errors' => $errors,
                    'author' => $author
                ]
            ];
        }


    }
}