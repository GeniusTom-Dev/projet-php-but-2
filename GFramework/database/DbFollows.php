<?php
use GFramework\utilities\GReturn;
class DbFollows {
    private string $dbName = "follows";

    private mysqli $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    /**
     * @param int $idUser
     * @return int
     * Give the number of person that the user follow
     */
    public function countFollowed(int $idUser) : int {
        $request = "SELECT COUNT(*) nbFollowed FROM $this->dbName WHERE ID_FOLLOWER= $idUser;";
        return intval(mysqli_fetch_assoc($this->conn->query($request))["nbFollowed"]);
    }

    /**
     * @param int $idUser
     * @return int
     * Give the number of persons who follow the user
     */
    public function countFollower(int $idUser) : int {
        $request = "SELECT COUNT(*) nbFollower FROM $this->dbName WHERE ID_FOLLOWED= $idUser;";
        return intval(mysqli_fetch_assoc($this->conn->query($request))["nbFollower"]);
    }

    /**
     * @param int $connectUser
     * @param int $otherUser
     * @return bool
     * Return true if the connected user follow another user, use for calling correct Sql request
     * and showing to the connected user that he follow this other user
     */
    public function doesUserFollowAnotherUser(int $connectUser, int $otherUser) : bool {
        $request = "SELECT * FROM $this->dbName";
        $request .= " WHERE ID_FOLLOWER = $connectUser AND ID_FOLLOWED = $otherUser;";
        $result = $this->conn->query($request);
        return !empty(mysqli_fetch_assoc($result));
    }

    public function addFollow(int $follower, int $followed) : bool {
        if ($this->doesUserFollowAnotherUser($follower, $followed)) {
            return false; // the modification was not made
        }
        $request = "INSERT INTO $this->dbName (`ID_FOLLOWER`, `ID_FOLLOWED`) VALUES ";
        $request .= "($follower, $followed);";
+       $this->conn->query($request);
        return true;
    }

    /* Remove follow */

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