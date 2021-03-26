<?php

function query($pdo, $sql, $parameters = []){
    $query = $pdo->prepare($sql);
    $query->execute($parameters);
    return $query;
}

function getAllFromDb($pdo, $table){
    $result = query($pdo, 'SELECT * FROM `'.$table.'`');
    return $result->fetchAll();
}

function insertJoke($pdo, $fields){
    $query = 'INSERT INTO `joke` SET';
    foreach ($fields as $key => $values){
        $query .= '`' . $key . '` = :' . $key . ',';
    }
    $query = rtrim($query, ',');

    $fields = processDates($fields);

    query($pdo, $query, $fields);
}

function getAllJokes($pdo){
    $sql = 'SELECT `joke`.`id`, `joketext`, `name`, `email`, `jokedate`
            FROM `joke`
            INNER JOIN `author`
            ON `author`.`id` = `authorid`';

    $query = query($pdo, $sql);
    return $query->fetchAll();
}

function getJoke($pdo, $id) {
    $parameters = [':id' => $id];
    $query = query($pdo, 'SELECT * FROM `joke` WHERE `id` = :id', $parameters);
    return $query->fetch();
}

function updateJoke($pdo, $fields) {
    $query = ' UPDATE `joke` SET ';
    foreach ($fields as $key => $value) {
        $query .= '`' . $key . '` = :' . $key . ',';
    }
    $query = rtrim($query, ',');
    $query .= ' WHERE `id` = :primaryKey';

    $fields = processDates($fields);
    $fields['primaryKey'] = $fields['id'];

    query($pdo, $query, $fields);
}

function deleteJoke($pdo, $id){
    $sql = 'DELETE FROM `joke` WHERE `id` = :id';
    $parameters = array(':id' => $id);
    query($pdo, $sql, $parameters);
}

function totalJokes($database){
    $query = query($database, 'SELECT COUNT(*) FROM `joke`');
    $row = $query->fetch();
    return $row[0];
}

function insertAuthor($pdo, $fields){
    $query = 'INSERT INTO `author` SET';
    foreach ($fields as $key => $value){
        $query .= '`'. $key .'` ='. $key .',';
    }
    $query = rtrim($query, ',');

    query($pdo, $query, $fields);
}

function allAuthors($pdo){
    $authors = query($pdo, 'SELECT * FROM `author`');
    return $authors;
}

function deleteAuthor($pdo, $id){
    $parameters = [':id' => $id];
    query($pdo, 'DELETE FROM `author` WHERE `id` = :id', $parameters);
}
function processDates($fields){
    foreach ($fields as $key => $value){
        if ($value instanceof DateTime){
            $fields[$key] = $value->format('Y-m-d');
        }
    }
    return $fields;
}