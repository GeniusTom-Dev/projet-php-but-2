<?php

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

    public function select($username = null) : GReturn{
        $request = "SELECT * FROM " . $this->dbName;
        if(empty($username) === false){
            $request .= " WHERE username = '" . $username . "'";
        }
        $result = $this->conn->query($request);
        $row = [];
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        }
        return new GReturn("ok", content: $row);
    }

    public function getUsers(): GReturn{
        $request = "SELECT id,username, adminLevel FROM " . $this->dbName;
        $result = $this->conn->query($request);
        $row = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $user = new \stdClass();
                $user->id = $row["id"];
                $user->username = $row["username"];
                $user->adminLevel = $row["adminLevel"];
                $allUsers[] = $user;
            }
        }
        return new GReturn("ok", content: $allUsers);
    }

}