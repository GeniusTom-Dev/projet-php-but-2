<?php
use GFramework\utilities\GReturn;
class DbFollows
{
    private string $dbName = "comments";

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
}