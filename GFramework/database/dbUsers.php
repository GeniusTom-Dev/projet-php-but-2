<?php


use utilities\GReturn;

class dbUsers{

    private string $dbName = "user";

    private \mysqli $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }


    public function addUsers($name, $password):void{

    }

    public function select(?int $id = null, ?string $username = null, ?string $firstConnect = null, ?bool $isAdmin = null, ?bool $isActivated = null, ?int $limit = null, int $page = 0, ?string $sort = null) : GReturn{
        $result = $this->select_SQLResult($id,$username,$firstConnect,$isAdmin,$isActivated,$limit,$page,$sort)->getContent();
        $row = [];
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        }
        return new GReturn("ok", content: $row);
    }

    public function select_SQLResult(?int $id = null, ?string $username = null, ?string $firstConnect = null, ?bool $isAdmin = null, ?bool $isActivated = null, ?int $limit = null, int $page = 0, ?string $sort = null) : GReturn{
        $request = "SELECT * FROM " . $this->dbName;
        if(empty($username) === false){
            $request .= " WHERE ID = $id" ;
            if (empty($firstConnect) === false){
                $request .= " AND USERNAME = '$username'";
            }
            if (empty($firstConnect) === false){
                $request .= " AND USER_CREATED = '$firstConnect'";
            }
            if (empty($isAdmin) === false){
                $request .= " AND IS_ADMIN = $isAdmin";
            }
            if (empty($isActivated) === false){
                $request .= " AND IS_ACTIVATED = $isActivated";
            }
        }
        if(empty($username) === false){
            $request .= " WHERE USERNAME = '$username'" ;
            if (empty($firstConnect) === false){
                $request .= " AND USER_CREATED = '$firstConnect'";
            }
            if (empty($isAdmin) === false){
                $request .= " AND IS_ADMIN = $isAdmin";
            }
            if (empty($isActivated) === false){
                $request .= " AND IS_ACTIVATED = $isActivated";
            }
        }
        else if (empty($firstConnect) === false){
            $request .= " WHERE USER_CREATED = '$firstConnect'";
            if (empty($isAdmin) === false){
                $request .= " AND IS_ADMIN = $isAdmin";
            }
            if (empty($isActivated) === false){
                $request .= " AND IS_ACTIVATED = $isActivated";
            }
        }
        else if (empty($isAdmin) === false){
            $request .= " WHERE IS_ADMIN = $isAdmin";
            if (empty($isActivated) === false){
                $request .= " AND IS_ACTIVATED = $isActivated";
            }
        }
        else if (empty($isActivated) === false){
            $request .= " WHERE IS_ACTIVATED = $isActivated";
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
            return 'ORDER BY ID ASC';
        }
        else if ($sort == 'a-z'){
            return 'ORDER BY USERNAME ASC';
        }
        else if ($sort == 'recent'){
            return 'ORDER BY USER_CREATED DESC';
        }
        return '';
    }

    public function getUsers(): GReturn{

        return new GReturn("ok", content: null);
    }

    public function deleteUser(string $username): void{
        $query = "DELETE FROM " . $this->dbName . " WHERE USERNAME='$username'";
        $this->conn->query($query);
    }

    public function deactivateUser(string $username): void{
        $query = "UPDATE " . $this->dbName . " SET IS_ACTIVATED=0 WHERE USERNAME='$username'";
        $this->conn->query($query);
    }

    public function activateUser(string $username): void{
        $query = "UPDATE " . $this->dbName . " SET IS_ACTIVATED=1 WHERE USERNAME='$username'";
        $this->conn->query($query);
    }
}