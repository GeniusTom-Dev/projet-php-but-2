<?php
use \GFramework\utilities\GReturn;

class DbUsers{

    private string $dbName = "users";

    private \mysqli $conn;

    private array | string $dbColumns = ["USERNAME", "USER_EMAIL", "USER_PWD", "IS_ACTIVATED", "IS_ADMIN", "USER_CREATED", "USER_LAST_CONNECTION", "USER_PROFIL_PIC", "USER_BIO"];


    public function __construct($conn){
        $this->conn = $conn;
    }


    // UTILISER DE PREFERENCE LE ASSOC ARRAY PLUTOT QUE LE RESULT SQL
    public function convertSQLResultToAssocArray(GReturn $result) : GReturn{
        return new GReturn("ok", content: mysqli_fetch_all($result->getContent(), MYSQLI_ASSOC));
    }

    /**
     * A function to execute a SELECT query with more than one parameter as well as sort and limit the result returned.
     * @param string|null $usernameLike A part of the username you want to find. If is null then parameter is not used in the search.
     * @param bool|null $isAdmin Determines if an admin (1) or a regular user (0) is searched. If is null then parameter is not used in the search.
     * @param bool|null $isActivated Determines if a user account is searched as activated (1) or deactivated (0). If is null then parameter is not used in the search.
     * @param int|null $limit Is the max number of rows to return. If is null then return all rows.
     * @param int|null $page Is the page associated with the request. Is used to calculate the offset for the limit. If is null then return all rows.
     * @param string|null $sort A string that indicates which sort by to used for the request. If is null then result is not sorted.
     * @return GReturn Returns the result of a SELECT query with the possibility to sort and limit the number of rows returned.
     * Used when you need to filter the table according to several non-unique key attributes
     */
    public function select_SQLResult(?string $usernameLike, ?bool $isAdmin, ?bool $isActivated, ?int $limit=null, ?int $page=null, ?string $sort=null) : GReturn{
        $request = "SELECT * FROM " . $this->dbName;
        $conditions = [];
        if (!is_null($usernameLike)) {
            $conditions[] = "USERNAME LIKE '$usernameLike%'";
        }
        if (!is_null($isAdmin)) {
            $conditions[] = "IS_ADMIN = " . ($isAdmin ? 'true' : 'false');
        }
        if (!is_null($isActivated)) {
            $conditions[] = "IS_ACTIVATED = " . ($isActivated ? 'true' : 'false');
        }
        if (!empty($conditions)) {
            $request .= " WHERE " . implode(" AND ", $conditions);
        }
        // Sorting result and limiting size for pagination
        $request .= " " . $this->getSortInstruction($sort);
        if (empty($limit) === false && empty($page) === false){
            $request .= " LIMIT " . ($page - 1) * $limit . ", $limit";
        }

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

    public function getTotal(){
        $query = "SELECT COUNT(*) AS TOTAL FROM " . $this->dbName;
        return $this->conn->query($query)->fetch_assoc()['TOTAL'];
    }

    // -------------------------- CODE MATHIEU --------------------------

    /* Select by primary key */

    public function selectById(int $id) : GReturn
    {
        $request = "SELECT * FROM $this->dbName";
        $request .= " WHERE USER_ID = $id;";
        $result = $this->conn->query($request);
        return new GReturn("ok", content: mysqli_fetch_assoc($result));
    }

    public function selectByUsername(string $username) : GReturn{
        $request = "SELECT * FROM $this->dbName";
        $request .= " WHERE USERNAME = '$username';";
        $result = $this->conn->query($request);
        return new GReturn("ok", content: mysqli_fetch_assoc($result));
    }

    public function selectByEmail(string $email) : GReturn{
        $request = "SELECT * FROM $this->dbName";
        $request .= " WHERE USER_EMAIL = '$email';";
        $result = $this->conn->query($request);
        return new GReturn("ok", content: mysqli_fetch_assoc($result));
    }

    /* Update User */

    public function updateUsername(string $oldUsername, string $newUsername) : bool {
        if ($this->isUsernameAlreadyUsed($newUsername) || !$this->isUsernameAlreadyUsed($oldUsername)) {
            return false; // the new username is already used, the update was not made
        }
        $request = "UPDATE $this->dbName SET USERNAME = '$newUsername'";
        $request .= " WHERE USERNAME = '$oldUsername';";
        $this->conn->query($request);
        return true;
    }

    public function activateUser(int $id): void{
        $query = "UPDATE $this->dbName SET IS_ACTIVATED=1 WHERE USER_ID=$id";
        $this->conn->query($query);
    }

    public function deactivateUser(int $id): void{
        $query = "UPDATE $this->dbName SET IS_ACTIVATED=0 WHERE USER_ID=$id";
        $this->conn->query($query);
    }

    /* Add User */

    public function addUser(string $username, string $email, string $pwd) : bool {
        if ($this->isUsernameAlreadyUsed($username) || $this->isEmailAlreadyUsed($email)) {
            return false; // the username or/and the email are already used
        }
        $resetIdMinValue = "ALTER TABLE $this->dbName AUTO_INCREMENT = 1;";
        $this->conn->query($resetIdMinValue);
        $request = "INSERT INTO $this->dbName (";
        $request .= "`" . implode("`, `", $this->dbColumns) . "`) VALUES (";
        $request .= "'$username', '$email', '$pwd', ";
        $request .= "1, 0, '" . date("Y-m-d") . "', '" . date("Y-m-d") . "'";
        $request .= ", null, null);";
        $this->conn->query($request);
        return true;
    }

    /* Delete User */

    public function deleteUserByID(int $id): void{
        $query = "DELETE FROM $this->dbName WHERE USER_ID=$id";
        $this->conn->query($query);
    }

    public function deleteUserByUsername(string $username): void{
        $query = "DELETE FROM " . $this->dbName . " WHERE USERNAME='$username'";
        $this->conn->query($query);
    }

    /* check if already exists functions */

    private function isUsernameAlreadyUsed(string $username) : bool {
        $request = "SELECT * FROM $this->dbName WHERE USERNAME = '$username'";
        return !empty(mysqli_fetch_assoc($this->conn->query($request)));
    }

    private function isEmailAlreadyUsed(string $email) : bool {
        $request = "SELECT * FROM $this->dbName WHERE USER_EMAIL = '$email'";
        return !empty(mysqli_fetch_assoc($this->conn->query($request)));
    }
}