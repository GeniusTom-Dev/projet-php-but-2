<?php


use GFramework\utilities\GReturn;

class dbUsers{

    private string $dbName = "users";

    private array | string $dbColumns = ["USER_ID", "USERNAME", "USER_EMAIL", "USER_PWD", "IS_ACTIVATED", "IS_ADMIN", "USER_CREATED", "USER_LAST_CONNECTION", "USER_PROFIL_PIC", "USER_BIO"];

    // Connection of db
    private \mysqli $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

//    public function addUsers($name, $password):void{
//
//        $request = "INSERT INTO " . $this->dbName;
//        $request .= " (licence,username,password, adminLevel) ";
//        $request .= "VALUES (";
//
//        $request .= "'" . uniqid() . "',";
//        $request .= "'" . $name . "',";
//        $request .= "'" . $password . "',";
//        $request .= 0 . ");";
//
//        $this->conn->query($request);
//    }

    /* Select by primary key */

    public function select_by_id(int $id) : GReturn {
        $request = "SELECT * FROM " . $this->dbName;
        $request .= " WHERE USER_ID = " . $id . ";";
        $result = $this->conn->query($request);
        return new GReturn("ok", content: mysqli_fetch_assoc($result));
    }

    public function select_by_username(string $username) : GReturn{
        $request = "SELECT * FROM " . $this->dbName;
        $request .= " WHERE USERNAME = '" . $username . "';";
        $result = $this->conn->query($request);
        return new GReturn("ok", content: mysqli_fetch_assoc($result));
    }

    public function select_by_email(string $email) : GReturn{
        $request = "SELECT * FROM " . $this->dbName;
        $request .= " WHERE USER_EMAIL = '" . $email . "';";
        $result = $this->conn->query($request);
        return new GReturn("ok", content: mysqli_fetch_assoc($result));
    }

    /* Get all the values and select the columns */

    public function getUsers(array | string $attributes = []): GReturn{
        $request = $this->createSelectStringWithAttributes($attributes);
        $request .= " FROM " . $this->dbName;
        $result = $this->conn->query($request);
        return new GReturn("ok", content: mysqli_fetch_all($result, MYSQLI_ASSOC));
    }

    private function createSelectStringWithAttributes(array | string $attributes = []): string {
        $select = "SELECT ";
        if (empty($attributes)) return $select . '*';
        if ($this->isAttributeInTable($attributes[0])) {
            $select .= $attributes[0];
            for ($i=1; $i<sizeof($attributes); $i++) {
                if ($this->isAttributeInTable($attributes[$i])) {
                    $select .= ", " . $attributes[$i];
                }
            }
        }
        return $select;
    }

    private function isAttributeInTable(string $attribute) : bool {
        return in_array($attribute, $this->dbColumns);
    }

    /* update an entry */

    public function updateUsername(string $oldUsername, string $newUsername) : bool {
        if ($this->isUsernameAlreadyUsed($newUsername)) {
            return false; // the username is already used, the update was not made
        }
        $request = "UPDATE " . $this->dbName . " SET USERNAME = '" . $newUsername. "'";
        $request .= " WHERE USERNAME = '" . $oldUsername . "';";
        $this->conn->query($request);
        return true;
    }

    /* check if already exists functions */

    private function isUsernameAlreadyUsed(string $username) {
        return in_array([$username], $this->getUsers(["USERNAME"])->getContent());
    }

    private function isEmailAlreadyUsed(string $email) {
        return in_array([$email], $this->getUsers(["USER_EMAIL"])->getContent());
    }
}