<?php
use GFramework\utilities\GReturn;

class DbFavorites
{
    private string $dbName = "favorites";
    private array | string $dbColumns = ["USER_ID", "POST_ID"];

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

    public function addFavorites(int $user_id, int $post_id) : bool {
        if ($this->doesUserHaveFavoritedThisPost($user_id, $post_id)) {
            return false; // Modification was not made
        }
        $request = "INSERT INTO $this->dbName (''";
        $request .= implode("', '",$this->dbColumns) . "')";
        $request .= " VALUES ($user_id, $post_id);";
        $this->conn->query($request);
        return true;
    }

    public function removeFavorite(int $user_id, int $post_id) {
        if (!$this->doesUserHaveFavoritedThisPost($user_id, $post_id)) {
            return false; // This entry doesn't exists in the table
        }
        $query = "DELETE FROM $this->dbName WHERE USER_ID=$user_id AND POST_ID=$post_id";
        $this->conn->query($query);
        return true;
    }
}




















