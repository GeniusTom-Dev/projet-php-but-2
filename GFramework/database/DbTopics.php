<?php

use \GFramework\utilities\GReturn;

class DbTopics
{
    private string $dbName = "topics";

    private \mysqli $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }
    public function getTotal(){
        $query = "SELECT COUNT(*) AS TOTAL FROM " . $this->dbName;
        return $this->conn->query($query)->fetch_assoc()['TOTAL'];
    }

    public function convertSQLResultToAssocArray(GReturn $result) : GReturn{
        return new GReturn("ok", content: mysqli_fetch_all($result->getContent(), MYSQLI_ASSOC));
    }

    public function select_SQLResult(?string $nameOrDescriptionLike, ?int $limit=null, ?int $page=null, ?string $sort=null) : GReturn{
        $request = "SELECT * FROM  $this->dbName";
        $conditions = [];
        if (!is_null($nameOrDescriptionLike)) {
            $conditions[] = "(NAME LIKE %$nameOrDescriptionLike% OR DESCRIPTION LIKE %$nameOrDescriptionLike%)";
        }
        if (!empty($conditions)) {
            $request .= " WHERE " . implode(" AND ", $conditions);
        }
        // Sorting result and limiting size for pagination
        $request .= " " . $this->getSortInstruction($sort);
        if (empty($limit) === false){
            $request .= " LIMIT " . ($page - 1) * $limit . ", $limit";
        }

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

    public function selectById(int $topic_id) : GReturn {
        $request = "SELECT * FROM $this->dbName";
        $request .= " WHERE TOPIC_ID = $topic_id;";
        $result = $this->conn->query($request);
        return new GReturn("ok", content: mysqli_fetch_assoc($result));
    }

    public function selectByName(string $topic_name) : GReturn {
        $request = "SELECT * FROM $this->dbName";
        $request .= " WHERE NAME = '$topic_name';";
        $result = $this->conn->query($request);
        return new GReturn("ok", content: mysqli_fetch_assoc($result));
    }

    /* Update Topic */

    public function changeTopicName($topic_id, $newName): bool {
        if (empty($newName)) {
            return false; // Topic's name can not be empty
        }
        $query = "UPDATE $this->dbName SET NAME='$newName' WHERE TOPIC_ID='$topic_id'";
        $this->conn->query($query);
        return true;
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