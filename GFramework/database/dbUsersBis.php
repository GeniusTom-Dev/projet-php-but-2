<?php


use GFramework\utilities\GReturn;

class dbUsersBis{

    private string $dbName = "users";

    private array | string $dbColumns = ["USERNAME", "USER_EMAIL", "USER_PWD", "IS_ACTIVATED", "IS_ADMIN", "USER_CREATED", "USER_LAST_CONNECTION", "USER_PROFIL_PIC", "USER_BIO"];

    // Connection of db
    private \mysqli $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    /* Select by primary key */

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

    /* add a user */

    public function addUser(string $username, string $email, string $pwd) : bool {
        if ($this->isUsernameAlreadyUsed($username) || $this->isEmailAlreadyUsed($email)) {
            return false; // the username or/and the email are already used
        }
        $request = "INSERT INTO `" . $this->dbName . "` (";
        $request .= "`" . implode("`, `", $this->dbColumns) . "`) VALUES (";
        $request .= "'" . $username . "', ";
        $request .= "'" . $email . "', ";
        $request .= "'" . $pwd . "', ";
        $request .= "1, 0, '" . date("Y-m-d") . "', '" . date("Y-m-d") . "'";
        $request .= ", null, null);";
        var_dump($request);
        $this->conn->query($request);
        return true;
    }

    /* update a user */

    public function updateUsername(string $oldUsername, string $newUsername) : bool {
        if ($this->isUsernameAlreadyUsed($newUsername) || !$this->isUsernameAlreadyUsed($oldUsername)) {
            return false; // the username is already used, the update was not made
        }
        $request = "UPDATE " . $this->dbName . " SET USERNAME = '" . $newUsername. "'";
        $request .= " WHERE USERNAME = '" . $oldUsername . "';";
        $this->conn->query($request);
        return true;
    }

    /* check if already exists functions */

    private function isUsernameAlreadyUsed(string $username) {
        return in_array(['USERNAME'=>$username], $this->getUsers(["USERNAME"])->getContent());
    }

    private function isEmailAlreadyUsed(string $email) {
        return in_array(['USER_EMAIL'=>$email], $this->getUsers(["USER_EMAIL"])->getContent());
    }
}
