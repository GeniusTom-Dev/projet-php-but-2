<?php
use \GFramework\utilities\GReturn;

class DbLikes
{
    private string $dbName = "likes";
    private array | string $dbColumns = ["USER_ID", "POST_ID"];

    private \mysqli $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    /**
     * @param int $user_id
     * @param int $post_id
     * @return bool
     * Used for showing to a user that he already liked a post
     */
    public function doesUserHasLikedThisPost(int $user_id, int $post_id) : bool {
        $request = "SELECT * FROM $this->dbName";
        $request .= " WHERE USER_ID = $user_id AND POST_ID = $post_id;";
        $result = $this->conn->query($request);
        return !empty(mysqli_fetch_assoc($result));
    }

    public function countPostLike(int $post_id) : int {

        // A VOIR SI BESOINS OU SI AJOUT ATTRIBUT DANS TABLE

        return 0;
    }

    /* Add Like */

    public function addLike(int $user_id, int $post_id) : bool {
        if ($this->doesUserHasLikedThisPost($user_id, $post_id)) {
            return false; // This entry already exists
        }
        $request = "INSERT INTO $this->dbName (";
        $request .= "`" . implode("`, `", $this->dbColumns) . "`)";
        $request .= " VALUES ($user_id, $post_id);";
        var_dump($request);
        $this->conn->query($request);
        return true;
    }
     /* Remove Like */
    public function removeLike(int $user_id, int $post_id) : bool {
        if (!$this->doesUserHasLikedThisPost($user_id, $post_id)) {
            return false; // This entry doesn't exist
        }
        $query = "DELETE FROM $this->dbName WHERE USER_ID=$user_id AND POST_ID=$post_id";
        $this->conn->query($query);
        return true;
    }
}