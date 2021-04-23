<?php
class Database{

    private $pdo;
    private $table;
    private $primaryKey;

    public function __construct(PDO $pdo, string $table, string $primaryKey) {
        $this->pdo = $pdo;
        $this->$table = $table;
        $this->primaryKey = $primaryKey;
    }

    // Query function to to process sql query
    private function query($sql, $parameters = []){
        $query = $this->pdo->prepare($sql);
        $query->execute($parameters);
        return $query;
    }

// Get all data from database
    public function findAll(){
        $result = $this->query( 'SELECT * FROM `'. $this->table .'`');
        return $result->fetchAll();
    }

// Delete record from database
    public function delete($id){
        $parameters = [':id' => $id];
        $this->query($this->pdo, 'DELETE FROM`' . $this->table . '` WHERE `' . $this->primarykey .'` = :id', $parameters);
    }

// Insert record into database
    private function insert($fields){
        $query = 'INSERT INTO `' . $this->table .'` SET';
        foreach ($fields as $key => $values){
            $query .= '`' . $key . '` = :' . $key . ',';
        }
        $query = rtrim($query, ',');

        $fields = $this->processDates($fields);

        $this->query($query, $fields);
    }

// Update record if find duplicate id
    public function save($record){
        try {
            if ($record[$this->primarykey] == '' ){
                $record[$this->primarykey] = null;
            }
            $this->insert($record);

        } catch (PDOException $e){
            $this->update($record);
        }
    }

// Update record in the database
    private function update($fields){
        $query = 'UPDATE `'. $this->table .'` SET ';
        foreach ($fields as $key => $value) {
            $query .= '`' . $key . '` = :' . $key . ',';
        }
        $query = rtrim($query, ',');
        $query .= ' WHERE `'. $this->primarykey .'` = :primarykey';

        $fields['primarykey'] = $fields['id'];
        $fields = $this->processDates($fields);

        $this->query($query, $fields);
    }

// Get one record from database
    public function findById($value){
        $query = 'SELECT * FROM `' . $this->table . '`WHERE `' . $this->primarykey . '` = :value';
        $parameters = [
            'value' => $value
        ];
        $query = $this->query($query, $parameters);

        return $query->fetch();
    }

// Get total number of records a database have
    public function total(){
        $query = $this->query('SELECT COUNT(*) FROM `'. $this->table .'`');
        $row = $query->fetch();
        return $row[0];
    }

// Date format
    private function processDates($fields){
        foreach ($fields as $key => $value){
            if ($value instanceof DateTime){
                $fields[$key] = $value->format('Y-m-d');
            }
        }
        return $fields;
    }
}
