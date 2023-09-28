<?php


use GFramework\utilities\GReturn;

class dbUsers{

    private string $dbName = "user";
    // Host of db server

    // Connection of db
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

    public function select($username = null) : GReturn{
        $request = "SELECT * FROM " . $this->dbName;
        if(empty($username) === false){
            $request .= " WHERE USERNAME = '" . $username . "'";
        }
        $result = $this->conn->query($request);
        return new GReturn("ok", content: $result);
    }

    public function getUsers(): GReturn{
        $request = "SELECT USER_ID, USERNAME, USER_EMAIL, USER_BIO FROM " . $this->dbName;
        $result = $this->conn->query($request);
        return new GReturn("ok", content: $result);
    }


    public function updateUserRank($id, $rank) : GReturn{
        if(isset($id) === false || isset($rank) === false){
            return new GReturn("ko", "id or rank null in updateUserRank -> DB Users");
        }
        $request = "UPDATE users SET adminLevel = " . $rank;
        $request .= " WHERE id = " . $id;


        $result = $this->conn->query($request);

        if($result){
            return new GReturn("ok");
        }else{
            return new GReturn("ko");
        }
    }
}