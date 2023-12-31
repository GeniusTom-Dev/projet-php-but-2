<?php
use GFramework\utilities\GReturn;

class DbFavorites
{
    private string $dbName = "favorites";
    private mysqli $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function doesUserHaveFavoritedThisPost(int $user_id, int $post_id) : bool {
        $request = "SELECT * FROM $this->dbName";
        $request .= " WHERE USER_ID = $user_id AND POST_ID = $post_id;";
        $result = $this->conn->query($request);
        return !empty(mysqli_fetch_assoc($result));
    }

    /* Add Favorite */

    public function addFavorite(int $user_id, int $post_id) : bool {
        if ($this->doesUserHaveFavoritedThisPost($user_id, $post_id)) {
            return false; // Modification was not made
        }
        $request = "INSERT INTO $this->dbName (`POST_ID`, `USER_ID`) VALUES ";
        $request .= "($post_id, $user_id);";
        $this->conn->query($request);
        return true;
    }

    /* Remove Favorite */

    public function removeFavorite(int $user_id, int $post_id) : bool {
        if (!$this->doesUserHaveFavoritedThisPost($user_id, $post_id)) {
            return false; // This entry doesn't exists in the table
        }
        $query = "DELETE FROM $this->dbName WHERE USER_ID=$user_id AND POST_ID=$post_id";
        $this->conn->query($query);
        return true;
    }
}




















