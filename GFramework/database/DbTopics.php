<?php

use GFramework\utilities\GReturn;

class DbTopics
{
    private string $dbName = "topics";

    private mysqli $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function convertSQLResultToAssocArray(GReturn $result) : GReturn{
        return new GReturn("ok", content: mysqli_fetch_all($result->getContent(), MYSQLI_ASSOC));
    }

    public function select_SQLResult(string $nameLike = null, string $descriptionLike = null, ?int $limit = null, int $page = 0, ?string $sort = null) : GReturn{
        $request = "SELECT * FROM  $this->dbName ";
        $conditions = [];
        if (!is_null($nameLike)) {
            $conditions[] = "NAME LIKE %$nameLike%";
        }
        if (!is_null($descriptionLike)) {
            $conditions[] = "DESCRITPION LIKE %$descriptionLike%";
        }
        if (!empty($conditions)) {
            $request .= "WHERE " . implode(" AND ", $conditions);
        }
        $request .= " " . $this->getSortInstruction($sort);
        $result = $this->conn->query($request);
        return new GReturn("ok", content: $result);
    }

    public function getSortInstruction(?string $sort): string{
        if ($sort == 'ID-asc'){
            return 'ORDER BY TOPIC_ID ASC';
        }
        else if ($sort == 'a-z'){
            return 'ORDER BY NAME ASC';
        }
        else if ($sort == 'recent'){
            return 'ORDER BY TOPIC_ID DESC';
        }
        return '';
    }

    /* Update Topic */

    public function changeTopicName($id, $newName): void{
        $query = "UPDATE $this->dbName SET NAME='$newName' WHERE TOPIC_ID=$id";
        $this->conn->query($query);
    }
    public function changeTopicDescription($id, $newDescription): void{
        $query = "UPDATE $this->dbName SET DESCRIPTION=";
        if ($newDescription == 'NULL'){
            $query .= "NULL";
        }
        else {
            $query .= "'$newDescription'";
        }
        $query .= " WHERE TOPIC_ID=$id";
        $this->conn->query($query);
    }

    public function changeTopic($id, $newName = null, $newDescription = null): void{
        if (empty($newName) === false && $newName != ''){
            $this->changeTopicName($id, $newName);
        }
        if (isset($newDescription) && $newDescription != ''){
            $this->changeTopicDescription($id, $newDescription);
        }
    }

    /* Add Topic */

    public function addTopic($name, $Description):void{
        $resetIdMinValue = "ALTER TABLE $this->dbName AUTO_INCREMENT = 1;";
        $this->conn->query($resetIdMinValue);
        $query = "INSERT INTO " . $this->dbName;
        $query .= " VALUES ('$name', ";
        if ($Description == ''){
            $query .= "NULL";
        }
        else{
            $query .= "'$Description'";
        }
        $query .= ");";
        $this->conn->query($query);
    }

    /* Delete Topic */

    public function deleteTopic($id): void{
        $query = "DELETE FROM $this->dbName WHERE TOPIC_ID = $id";
        $this->conn->query($query);
    }

}