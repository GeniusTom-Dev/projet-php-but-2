<?php

use utilities\GReturn;

class dbTopics
{
    private string $dbName = "topic";

    private \mysqli $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }


    public function addTopic($name, $info):void{
        $nextID = mysqli_query($this->conn, "SELECT (MAX(ID) + 1) AS NEWID FROM ". $this->dbName);
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

    public function select($id = null, $name = null, ?int $limit = null) : GReturn{
        $request = "SELECT * FROM " . $this->dbName;
        if(empty($id) === false){
            $request .= " WHERE ID = " . $id ;
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
        $result = $this->conn->query($request);
        $rows = [];
        if ($result->num_rows > 0) {
            $rows = $result->fetch_assoc();
        }
        return new GReturn("ok", content: $rows);
    }

    public function select_SQLResult($id = null, $name = null, $limit = null) : GReturn{
        $request = "SELECT * FROM " . $this->dbName;
        if(empty($id) === false){
            $request .= " WHERE ID = " . $id ;
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
        $result = $this->conn->query($request);
        return new GReturn("ok", content: $result);
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
        $query = "UPDATE " . $this->dbName . " SET NAME='$newName' WHERE ID=$id";
        $this->conn->query($query);
    }
    public function changeTopicInfo($id, $newInfo): void{
        $query = "UPDATE " . $this->dbName . " SET INFO=";
        if ($newInfo == 'NULL'){
            $query .= "NULL";
        }
        else {
            $query .= "'$newInfo'";
        }
        $query .= " WHERE ID=$id";
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
        $query = "DELETE FROM " . $this->dbName . " WHERE ID=$id";
        $this->conn->query($query);
    }

}