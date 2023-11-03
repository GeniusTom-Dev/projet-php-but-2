<?php

/**
 * Singleton used to initialize the connection with the DbFollows table and perform queries
 */
class DbFollows {
    private string $dbName = "follows";

    private mysqli $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    /**
     * Count the number of users followed by a specific user.
     *
     * @param int $idUser
     * @return int
     */
    public function countFollowed(int $idUser) : int {
        $request = "SELECT COUNT(*) nbFollowed FROM $this->dbName WHERE ID_FOLLOWER= $idUser;";
        return intval(mysqli_fetch_assoc($this->conn->query($request))["nbFollowed"]);
    }

    /**
     * Count the number of users following a specific user.
     *
     * @param int $idUser
     * @return int
     */
    public function countFollower(int $idUser) : int {
        $request = "SELECT COUNT(*) nbFollower FROM $this->dbName WHERE ID_FOLLOWED= $idUser;";
        return intval(mysqli_fetch_assoc($this->conn->query($request))["nbFollower"]);
    }

    /**
     * Check if one user follows another user.
     *
     * @param int $connectUser The ID of the user who is following.
     * @param int $otherUser The ID of the user who is being followed.
     * @return bool True if the connect user follows the other user, false otherwise.
     */
    public function doesUserFollowAnotherUser(int $connectUser, int $otherUser) : bool {
        $request = "SELECT * FROM $this->dbName";
        $request .= " WHERE ID_FOLLOWER = $connectUser AND ID_FOLLOWED = $otherUser;";
        $result = $this->conn->query($request);
        return !empty(mysqli_fetch_assoc($result));
    }

    /**
     * Add a follow relationship between two users.
     *
     * @param int $follower The ID of the user who is following.
     * @param int $followed The ID of the user who is being followed.
     * @return bool True if the follow relationship was successfully added, false if the relationship already exists.
     */
    public function addFollow(int $follower, int $followed) : bool {
        if ($this->doesUserFollowAnotherUser($follower, $followed)) {
            return false; // the modification was not made
        }
        $request = "INSERT INTO $this->dbName (`ID_FOLLOWER`, `ID_FOLLOWED`) VALUES ";
        $request .= "($follower, $followed);";
        +       $this->conn->query($request);
        return true;
    }

    /**
     * Remove a follow relationship between two users in the database.
     *
     * @param int $connectedUser The ID of the user who is currently following.
     * @param int $otherUser The ID of the user who is currently being followed.
     * @return bool True if the follow relationship was successfully removed, false if the relationship doesn't exist in the table.
     */
    public function removeFollow(int $connectedUser, int $otherUser) : bool {
        if (!$this->doesUserFollowAnotherUser($connectedUser, $otherUser)) {
            return false; // This entry doesn't exist in the table
        }
        $request = "DELETE FROM $this->dbName";
        $request .= " WHERE ID_FOLLOWER = $connectedUser AND ID_FOLLOWED = $otherUser;";
        $this->conn->query($request);
        return true;
    }
}