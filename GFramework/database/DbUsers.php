<?php
use \GFramework\utilities\GReturn;

class DbUsers{

    private string $dbName = "users";

    private \mysqli $conn;

    private array | string $dbColumns = ["USER_ID", "USERNAME", "USER_EMAIL", "USER_PWD", "IS_ACTIVATED", "IS_ADMIN", "USER_CREATED", "USER_LAST_CONNECTION", "USER_PROFIL_PIC", "USER_BIO"];


    public function __construct($conn){
        $this->conn = $conn;
    }

    // -------------------------- CODE CAMILLE --------------------------

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
        if(empty($id) === false){
            $request .= " WHERE USER_ID = $id" ;
            if (empty($username) === false){
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
            return 'ORDER BY USER_ID ASC';
        }
        else if ($sort == 'a-z'){
            return 'ORDER BY USERNAME ASC';
        }
        else if ($sort == 'recent'){
            return 'ORDER BY USER_CREATED DESC';
        }
        else if ($sort == 'recent-connect'){
            return 'ORDER BY USER_LAST_CONNECTION DESC';
        }
        return '';
    }

    public function deleteUserByUsername(string $username): void{
        $query = "DELETE FROM " . $this->dbName . " WHERE USERNAME='$username'";
        $this->conn->query($query);
    }

    public function deleteUserByID(int $id): void{
        $query = "DELETE FROM " . $this->dbName . " WHERE USER_ID=$id";
        $this->conn->query($query);
    }

    public function deactivateUser(int $id): void{
        $query = "UPDATE " . $this->dbName . " SET IS_ACTIVATED=0 WHERE USER_ID=$id";
        $this->conn->query($query);
    }

    public function activateUser(int $id): void{
        $query = "UPDATE " . $this->dbName . " SET IS_ACTIVATED=1 WHERE USER_ID=$id";
        $this->conn->query($query);
    }

    // -------------------------- CODE MATHIEU --------------------------

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
        $request = "INSERT INTO " . $this->dbName . " (";
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