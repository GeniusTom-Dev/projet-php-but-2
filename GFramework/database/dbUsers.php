<?php


use utilities\GReturn;

class dbUsers{

    private string $dbName = "user";

    private \mysqli $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }


    public function addUsers($name, $password):void{

        $request = "INSERT INTO " . $this->dbName;
        $request .= " (licence,username,password, adminLevel) ";
        $request .= "VALUES (";

        $request .= "'" . uniqid() . "',";
        $request .= "'" . $name . "',";
        $request .= "'" . $password . "',";
        $request .= 0 . ");";

        $this->conn->query($request);
    }

    public function select($username = null, $firstConnect = null, ?bool $isAdmin = null) : GReturn{
        $request = "SELECT * FROM " . $this->dbName;
        if(empty($username) === false){
            $request .= " WHERE USERNAME = " . $username ;
            if (empty($firstConnect) === false){
                $request .= " AND USER_CREATED = '$firstConnect'";
            }
            if (empty($isAdmin) === false){
                $request .= " AND IS_ADMIN = $isAdmin";
            }
        }
        else if (empty($firstConnect) === false){
            $request .= " WHERE USER_CREATED = '$firstConnect'";
            if (empty($isAdmin) === false){
                $request .= " AND IS_ADMIN = $isAdmin";
            }
        }
        else if (empty($isAdmin) === false){
            $request .= " WHERE IS_ADMIN = $isAdmin";
        }
        $result = $this->conn->query($request);
        $row = [];
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        }
        return new GReturn("ok", content: $row);
    }

    public function select_SQLResult($username = null, $firstConnect = null, ?bool $isAdmin = null) : GReturn{
        $request = "SELECT * FROM " . $this->dbName;
        if(empty($username) === false){
            $request .= " WHERE USERNAME = '" . $username . "'" ;
            if (empty($firstConnect) === false){
                $request .= " AND USER_CREATED = '$firstConnect'";
            }
            if (empty($isAdmin) === false){
                $request .= " AND IS_ADMIN = $isAdmin";
            }
        }
        else if (empty($firstConnect) === false){
            $request .= " WHERE USER_CREATED = '$firstConnect'";
            if (empty($isAdmin) === false){
                $request .= " AND IS_ADMIN = $isAdmin";
            }
        }
        else if (empty($isAdmin) === false){
            $request .= " WHERE IS_ADMIN = $isAdmin";
        }
        $result = $this->conn->query($request);

        return new GReturn("ok", content: $result);
    }

    public function getUsers(): GReturn{

        return new GReturn("ok", content: null);
    }

    public function deleteUser($username): void{
        $query = "DELETE FROM " . $this->dbName . " WHERE USERNAME='$username'";
        $this->conn->query($query);
    }

    public function deactivateUser($username): void{
        $query = "UPDATE " . $this->dbName . " SET IS_ACTIVATED=0 WHERE USERNAME='$username'";
        $this->conn->query($query);
    }

    public function activateUser($username): void{
        $query = "UPDATE " . $this->dbName . " SET IS_ACTIVATED=1 WHERE USERNAME='$username'";
        $this->conn->query($query);
    }
}