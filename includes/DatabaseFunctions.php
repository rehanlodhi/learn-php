<?php

function query($pdo, $sql, $parameters = []){
    $query = $pdo->prepare($sql);
    $query->execute($parameters);
    return $query;
}

function insertJoke($pdo, $joketext, $authorid){
    $query = 'INSERT INTO `joke` SET
    `joketext` = :joketext,
    `jokedate` = CURDATE(),
    `authorid` = :authorid';

    $parameters = [':joketext'=> $joketext, ':authorid' => $authorid];
    query($pdo, $query, $parameters);
}

function getAllJokes($pdo){
    $sql = 'SELECT `joke`.`id`, `joketext`, `name`, `email`
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

function updateJoke($pdo, $jokeid, $joketext, $authorid){
    $query = 'UPDATE `joke` SET `id` = :id, `joketext` = :joketext, `authorid` = :authorid WHERE `id` = :id';
    $paramaeters = array(
        ':id' => $jokeid,
        ':joketext' => $joketext,
        ':authorid' => $authorid
    );

    query( $pdo, $query, $paramaeters );
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