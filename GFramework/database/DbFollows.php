<?php
use GFramework\utilities\GReturn;
class DbFollows
{
    private string $dbName = "comments";
    private array | string $dbColumns = ["ID_FOLLOWER", "ID_FOLLOWED", "SINCE_WHEN"];

    private mysqli $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    /**
     * @param int $idUser
     * @return int
     * Give the number of person that the user follow
     */
    public function countFollowedUser(int $idUser) : int {
        $request = "SELECT COUNT(*) FROM $this->dbName";
        $request .= " WHERE ID_FOLLOWER= $idUser;";
        // a finir et voir si on s'en sert
        return 0;
    }

    /**
     * @param int $idUser
     * @return int
     * Give the number of persons who follow the user
     */
    public function countFollower(int $idUser) : int {
        $request = "SELECT COUNT(*) FROM $this->dbName";
        $request .= " WHERE ID_FOLLOWED= $idUser;";
        // a finir
        return 0;
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

    // DATE A CHANGER A VOIR PLUS TARD
    public function addFollow(int $follower, int $followed) : bool {
        // CHECK IF USERNAME EXIST ???
        if ($this->doesUserFollowAnotherUser($follower, $followed)); {
            return false; // the modification was not made
        }
        $request = "INSERT INTO $this->dbName (";
        $request .= "`" . implode("`, `", $this->dbColumns) . "`) VALUES (";
        $request .= "$follower, $followed, '2023-10-02');";
+       $this->conn->query($request);
        return true;
    }

    /**
     * @param int $connectedUser
     * @param int $otherUser
     * @return bool
     */
    public function deleteFollow(int $connectedUser, int $otherUser) : bool {
        if (!$this->doesUserFollowAnotherUser($connectedUser, $otherUser)) {
            return false; // This entry doesn't exist in the table
        }
        $request = "DELETE FROM $this->dbName";
        $request .= " WHERE ID_FOLLOWER = $connectedUser AND ID_FOLLOWED = $otherUser;";
        $this->conn->query($request);
        return true;
    }
}