<?php


use GFramework\utilities\GReturn;

class dbUsers{

    private string $dbName = "users";

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