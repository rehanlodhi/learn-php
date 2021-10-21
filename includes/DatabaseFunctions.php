<?php
// Query function to to process sql query
function query($pdo, $sql, $parameters = [])
{
    $query = $pdo->prepare($sql);
    $query->execute($parameters);
    return $query;
}

// Get all data from database
function findAll($pdo, $table)
{
    $result = query($pdo, 'SELECT * FROM `' . $table . '`');
    return $result->fetchAll();
}

// Delete record from database
function delete($pdo, $table, $primarykey, $id)
{
    $parameters = [':id' => $id];
    query($pdo, 'DELETE FROM`' . $table . '` WHERE `' . $primarykey . '` = :id', $parameters);
}

// Insert record into database
function insert($pdo, $table, $fields)
{
    $query = 'INSERT INTO `' . $table . '` SET';
    foreach ($fields as $key => $values) {
        $query .= '`' . $key . '` = :' . $key . ',';
    }
    $query = rtrim($query, ',');

    $fields = processDates($fields);

    query($pdo, $query, $fields);
}

// Update record if find duplicate id
function save($pdo, $table, $primarykey, $record)
{
    try {
        if ($record[$primarykey] == '') {
            $record[$primarykey] = null;
        }
        insert($pdo, $table, $record);

    } catch (PDOException $e) {
        update($pdo, $table, $primarykey, $record);
    }
}

// Update record in the database
function update($pdo, $table, $primarykey, $fields)
{
    $query = ' UPDATE `' . $table . '` SET ';
    foreach ($fields as $key => $value) {
        $query .= '`' . $key . '` = :' . $key . ',';
    }
    $query = rtrim($query, ',');
    $query .= ' WHERE `' . $primarykey . '` = :primarykey';

    $fields['primarykey'] = $fields['id'];
    $fields = processDates($fields);

    query($pdo, $query, $fields);
}

// Get one record from database
function findById($pdo, $table, $primarykey, $value)
{
    $query = 'SELECT * FROM `' . $table . ' `WHERE `' . $primarykey . '` = :value';
    $parameters = [
        'value' => $value
    ];
    $query = query($pdo, $query, $parameters);

    return $query->fetch();
}

// Get total number of records a database have
function total($pdo, $table)
{
    $query = query($pdo, 'SELECT COUNT(*) FROM `' . $table . '`');
    $row = $query->fetch();
    return $row[0];
}

// Date format
function processDates($fields)
{
    foreach ($fields as $key => $value) {
        if ($value instanceof DateTime) {
            $fields[$key] = $value->format('Y-m-d');
        }
    }
    return $fields;
}


function insertJoke($pdo, $fields)
{
    $query = 'INSERT INTO `joke` SET';
    foreach ($fields as $key => $values) {
        $query .= '`' . $key . '` = :' . $key . ',';
    }
    $query = rtrim($query, ',');

    $fields = processDates($fields);

    query($pdo, $query, $fields);
}

function getAllJokes($pdo)
{
    $sql = 'SELECT `joke`.`id`, `joketext`, `name`, `email`, `jokedate`
            FROM `joke`
            INNER JOIN `author`
            ON `author`.`id` = `authorid`';

    $query = query($pdo, $sql);
    return $query->fetchAll();
}

function getJoke($pdo, $id)
{
    $parameters = [':id' => $id];
    $query = query($pdo, 'SELECT * FROM `joke` WHERE `id` = :id', $parameters);
    return $query->fetch();
}

function updateJoke($pdo, $fields)
{
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

function deleteJoke($pdo, $id)
{
    $sql = 'DELETE FROM `joke` WHERE `id` = :id';
    $parameters = array(':id' => $id);
    query($pdo, $sql, $parameters);
}

function totalJokes($database)
{
    $query = query($database, 'SELECT COUNT(*) FROM `joke`');
    $row = $query->fetch();
    return $row[0];
}

function insertAuthor($pdo, $fields)
{
    $query = 'INSERT INTO `author` SET';
    foreach ($fields as $key => $value) {
        $query .= '`' . $key . '` =' . $key . ',';
    }
    $query = rtrim($query, ',');
    $fields = processDates($fields);
    query($pdo, $query, $fields);
}

function allAuthors($pdo)
{
    $authors = query($pdo, 'SELECT * FROM `author`');
    return $authors->fetchAll();
}

function deleteAuthor($pdo, $id)
{
    $parameters = [':id' => $id];
    query($pdo, 'DELETE FROM `author` WHERE `id` = :id', $parameters);
}
