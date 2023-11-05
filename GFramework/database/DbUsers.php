<?php

use GFramework\utilities\GReturn;

/**
 * Singleton used to initialize the connection with the DbUsers table and perform queries
 */
class DbUsers
{
    private string $dbName = "users";
    private mysqli $conn;
    private array|string $dbColumns = ["USERNAME", "USER_EMAIL", "USER_PWD", "IS_ACTIVATED", "IS_ADMIN", "USER_CREATED", "USER_LAST_CONNECTION", "USER_PROFIL_PIC", "USER_BIO"];

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    /**
     * Get the total number of users based on optional filtering criteria.
     *
     * @param string|null $usernameLike (optional)
     * @param bool|null $isAdmin (optional)
     * @param bool|null $isActivated (optional)
     * @return int
     */
    public function getTotal(?string $usernameLike, ?bool $isAdmin, ?bool $isActivated): int
    {
        $query = "SELECT COUNT(*) AS TOTAL FROM " . $this->dbName;
        // Filtering result
        $query .= " " . $this->getWhereInstruction($usernameLike, $isAdmin, $isActivated);
        return $this->conn->query($query)->fetch_assoc()['TOTAL'];
    }

    /**
     * @param string|null $usernameLike (optional)
     * @param bool|null $isAdmin (optional)
     * @param bool|null $isActivated (optional)
     * @param int|null $limit (optional)
     * @param int|null $page (optional)
     * @param string|null $sort (optional)
     * @return GReturn
     * Used when you need to filter the table according to several non-unique key attributes
     */
    public function select_SQLResult(?string $usernameLike=null, ?bool $isAdmin=null, ?bool $isActivated=null, ?int $limit = null, ?int $page = null, ?string $sort = null): GReturn
    {
        $request = "SELECT * FROM " . $this->dbName;
        // Filtering result
        $request .= " " . $this->getWhereInstruction($usernameLike, $isAdmin, $isActivated);
        // Sorting result and limiting size for pagination
        $request .= " " . $this->getSortAndLimit($limit, $page, $sort);

        $result = $this->conn->query($request);
        return new GReturn("ok", content: mysqli_fetch_all($result, MYSQLI_ASSOC));
    }

    /**
     * Generate the WHERE clause for SQL queries based on optional filtering criteria.
     *
     * @param string|null $usernameLike (optional)
     * @param bool|null $isAdmin (optional)
     * @param bool|null $isActivated (optional)
     * @return string
     */
    public function getWhereInstruction(?string $usernameLike, ?bool $isAdmin, ?bool $isActivated): string{
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
            $query = " WHERE " . implode(" AND ", $conditions);
        }
        else{
            $query = "";
        }
        return $query;
    }

    /**
     * Generate an SQL sorting instruction based on the specified sorting option.
     *
     * @param string|null $sort (optional)
     * @return string
     */
    public function getSortInstruction(?string $sort): string
    {
        if ($sort == 'ID-asc') {
            return 'ORDER BY USER_ID ASC';
        } else if ($sort == 'a-z') {
            return 'ORDER BY USERNAME ASC';
        } else if ($sort == 'recent') {
            return 'ORDER BY USER_CREATED DESC';
        } else if ($sort == 'recent-connect') {
            return 'ORDER BY USER_LAST_CONNECTION DESC';
        }
        return '';
    }

    /**
     * Generate SQL sorting and pagination instructions based on optional parameters.
     *
     * @param int|null $limit (optional)
     * @param int|null $page (optional)
     * @param string|null $sort (optional)
     * @return string
     */
    public function getSortAndLimit(?int $limit, ?int $page, ?string $sort): string{
        $request = '';
        if ($sort != null) {
            $request .= " " . $this->getSortInstruction($sort);
        }
        if ($limit != null && $page != null) {
            $request .= " LIMIT " . ($page - 1) * $limit . ", $limit";
        }
        return $request;
    }

    /**
     * Retrieve a specific user from the database by its ID.
     *
     * @param int $id
     * @return GReturn
     */
    public function selectById(int $id): GReturn
    {
        $request = "SELECT * FROM $this->dbName";
        $request .= " WHERE USER_ID = $id ";
        $result = $this->conn->query($request);
        return new GReturn("ok", content: mysqli_fetch_assoc($result));
    }

    /**
     * Retrieve a specific user from the database by its Username.
     *
     * @param string $username
     * @return GReturn
     */
    public function selectByUsername(string $username): GReturn
    {
        $request = "SELECT * FROM $this->dbName";
        $request .= " WHERE USERNAME = '$username' ";
        $result = $this->conn->query($request);
        return new GReturn("ok", content: mysqli_fetch_assoc($result));
    }

    /**
     * Retrieve a specific user from the database by its email.
     *
     * @param string $email
     * @return GReturn
     */
    public function selectByEmail(string $email): GReturn
    {
        $request = "SELECT * FROM $this->dbName";
        $request .= " WHERE USER_EMAIL = '$email' ";
        $result = $this->conn->query($request);
        return new GReturn("ok", content: mysqli_fetch_assoc($result));
    }

    /**
     * Activate a user in the database by setting their activation status to true.
     *
     * @param int $id
     * @return void
     */
    public function activateUser(int $id): void
    {
        $query = "UPDATE $this->dbName SET IS_ACTIVATED=1 WHERE USER_ID=$id";
        $this->conn->query($query);
    }

    /**
     * Deactivate a user in the database by setting their activation status to false.
     *
     * @param int $id
     * @return void
     */
    public function deactivateUser(int $id): void
    {
        $query = "UPDATE $this->dbName SET IS_ACTIVATED=0 WHERE USER_ID=$id";
        $this->conn->query($query);
    }

    /**
     * Add a new user to the database.
     *
     * @param string $username
     * @param string $email
     * @param string $pwd
     * @return bool True if the update was successful; false if the username or email is already used.
     */
    public function addUser(string $username, string $email, string $pwd): bool
    {
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

    /**
     * Update a username in the database.
     *
     * @param string $oldUsername
     * @param string $newUsername
     * @return bool True if the update was successful; false if a user with this username already exists or if the new username is empty.
     */
    public function updateUsername(string $oldUsername, string $newUsername): bool
    {
        if ($this->isUsernameAlreadyUsed($newUsername) || !$this->isUsernameAlreadyUsed($oldUsername)) {
            return false; // the new username is already used, the update was not made
        }
        $request = "UPDATE $this->dbName SET USERNAME = '$newUsername'";
        $request .= " WHERE USERNAME = '$oldUsername';";
        $this->conn->query($request);
        return true;
    }

    /**
     * Update a user's bio in the database.
     *
     * @param int $userID
     * @param string $newBio
     * @return bool True if the update was successful
     */
    public function updateBio(int $userID, ?string $newBio): bool
    {
        $request = "UPDATE $this->dbName SET USER_BIO = '$newBio'";
        $request .= " WHERE USER_ID = $userID";
        $this->conn->query($request);
        return true;
    }

    /**
     * Update a user's last connection in the database.
     *
     * @param int $userID
     * @param string $newConnexion
     * @return void
     */
    public function updateLastConnect(int $userID, string $newConnexion): void
    {
        $request = "UPDATE $this->dbName SET USER_LAST_CONNECTION = '$newConnexion'";
        $request .= " WHERE USER_ID = $userID";
        $this->conn->query($request);
    }

    /**
     * Update a user's profil pic in the database.
     *
     * @param int $userId
     * @param string|null $newProfilPic
     * @return void
     */
    public function updateProfilPic(int $userId, ?string $newProfilPic) : void {
        $request = "UPDATE $this->dbName SET USER_PROFIL_PIC = '$newProfilPic'";
        $request .= " WHERE USER_ID = $userId";
        $this->conn->query($request);
    }

    /**
     * Delete a user from the database by its ID.
     *
     * @param int $id
     * @return void
     */
    public function deleteUserByID(int $id): void
    {
        $query = "DELETE FROM $this->dbName WHERE USER_ID=$id";
        $this->conn->query($query);
    }

    /**
     * Check if a username is already in use by another user in the database.
     *
     * @param string $username
     * @return bool True if the username is already used, false otherwise.
     */
    public function isUsernameAlreadyUsed(string $username): bool
    {
        $request = "SELECT * FROM $this->dbName WHERE USERNAME = '$username'";
        return !empty(mysqli_fetch_assoc($this->conn->query($request)));
    }

    /**
     * Check if an email is already in use by another user in the database.
     *
     * @param string $email
     * @return bool True if the email is already used, false otherwise.
     */
    public function isEmailAlreadyUsed(string $email): bool
    {
        $request = "SELECT * FROM $this->dbName WHERE USER_EMAIL = '$email'";
        return !empty(mysqli_fetch_assoc($this->conn->query($request)));
    }

    public function getPasswordFromLogin(string $login, string $typeConnection): string
    {
        if ($typeConnection === "login") {
            $request = "SELECT USER_PWD FROM $this->dbName WHERE USERNAME = '$login'";
        } else {
            $request = "SELECT USER_PWD FROM $this->dbName WHERE USER_EMAIL = '$login'";
        }
        $result = $this->conn->query($request);
        return mysqli_fetch_assoc($result)["USER_PWD"];
    }

    public function getUserIdFromLogin(string $login, string $typeConnection): int
    {
        if ($typeConnection === "login") {
            $request = "SELECT USER_ID FROM $this->dbName WHERE USERNAME = '$login'";
        } else {
            $request = "SELECT USER_ID FROM $this->dbName WHERE USER_EMAIL = '$login'";
        }
        $result = $this->conn->query($request);
        return mysqli_fetch_assoc($result)["USER_ID"];
    }

    public function isAdminFromId(string $user_id): bool
    {
        $request = "SELECT IS_ADMIN FROM $this->dbName WHERE USER_ID = $user_id";
        $result = $this->conn->query($request);
        return mysqli_fetch_assoc($result)["IS_ADMIN"];
    }


}