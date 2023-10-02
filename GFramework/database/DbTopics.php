<?php

use \GFramework\utilities\GReturn;

class DbTopics
{
    private string $dbName = "topics";

    private \mysqli $conn;

    public function __construct($conn){
        $this->conn = $conn;
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

    public function select(?int $id = null, ?string $name = null, ?int $limit = null, int $page = 0, ?string $sort = null) : GReturn{
        $result = $this->select_SQLResult($id,$name,$limit,$page,$sort)->getContent();
        $rows = [];
        if ($result->num_rows > 0) {
            $rows = $result->fetch_assoc();
        }
        return new GReturn("ok", content: $rows);
    }

    public function select_SQLResult(?int $id = null, ?string $name = null, ?int $limit = null, int $page = 0, ?string $sort = null) : GReturn{
        $request = "SELECT * FROM " . $this->dbName;
        if(empty($id) === false){
            $request .= " WHERE TOPIC_ID = " . $id ;
            if (empty($name) === false){
                $request .= " AND NAME = '" . $name . "'";
            }
        }
        else if (empty($name) === false){
            $request .= " WHERE NAME = '" . $name . "'";
        }
        if (empty($limit) === false){
            $request .= " LIMIT " . $limit;
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

    public function selectLike($name = null, $info = null, $limit = null) : GReturn{
        $request = "SELECT * FROM " . $this->dbName;
        if(empty($name) === false){
            $request .= " WHERE NAME LIKE '%" . $name . "%'";
            if (empty($info) === false){
                $request .= " AND INFO LIKE '%" . $info . "%'";
            }
        }
        else if (empty($name) === false){
            $request .= " WHERE INFO LIKE '%" . $info . "%'";
        }
        if (empty($limit) === false){
            $request .= " LIMIT " . $limit;
        }
        $result = $this->conn->query($request);
        $rows = [];
        if ($result->num_rows > 0) {
            $rows = $result->fetch_assoc();
        }
        return new GReturn("ok", content: $rows);
    }

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