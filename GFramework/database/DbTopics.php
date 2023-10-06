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

    public function addTopic($name, $info):void{
        $nextID = mysqli_query($this->conn, "SELECT (MAX(TOPIC_ID) + 1) AS NEWID FROM ". $this->dbName);
        $nextID = mysqli_fetch_assoc($nextID);
        $nextID = $nextID['NEWID'];
        $query = "INSERT INTO " . $this->dbName;
        $query .= " VALUES ($nextID, '$name', ";
        if ($info == ''){
            $query .= "NULL";
        }
        else{
            $query .= "'$info'";
        }
        $query .= ");";

        $this->conn->query($query);
    }

    public function convertSQLResultToAssocArray(GReturn $result) : GReturn{
        return new GReturn("ok", content: mysqli_fetch_all($result->getContent(), MYSQLI_ASSOC));
    }

    public function select_SQLResult(string $nameLike = null, string $descriptionLike = null, ?int $limit = null, int $page = 0, ?string $sort = null) : GReturn{
        $request = "SELECT * FROM " . $this->dbName;
        $conditions = [];
        if (!is_null($nameLike)) {
            $conditions[] = "NAME LIKE %$nameLike%";
        }
        if (!is_null($descriptionLike)) {
            $conditions[] = "DESCRITPION LIKE %$descriptionLike%";
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

    /* Update Topic */

    public function changeTopicName($id, $newName): void{
        $query = "UPDATE " . $this->dbName . " SET NAME='$newName' WHERE TOPIC_ID=$id";
        $this->conn->query($query);
    }
    public function changeTopicInfo($id, $newInfo): void{
        $query = "UPDATE " . $this->dbName . " SET DESCRIPTION=";
        if ($newInfo == 'NULL'){
            $query .= "NULL";
        }
        else {
            $query .= "'$newInfo'";
        }
        $query .= " WHERE TOPIC_ID=$id";
        $this->conn->query($query);
    }

    public function changeTopic($id, $newName = null, $newInfo = null): void{
        if (empty($newName) === false && $newName != ''){
            $this->changeTopicName($id, $newName);
        }
        if (isset($newInfo) && $newInfo != ''){
            $this->changeTopicInfo($id, $newInfo);
        }
    }

    public function deleteTopic($id): void{
        $query = "DELETE FROM " . $this->dbName . " WHERE TOPIC_ID=$id";
        $this->conn->query($query);
    }

}