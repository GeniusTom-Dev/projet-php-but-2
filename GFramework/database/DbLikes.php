<?php

/**
 * Singleton used to initialize the connection with the DbLikes table and perform queries
 */
class DbLikes
{
    private string $dbName = "likes";
    private array | string $dbColumns = ["USER_ID", "POST_ID"];

    private \mysqli $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    /**
     * Check if a user has liked a specific post in the database.
     *
     * @param int $user_id
     * @param int $post_id
     * @return bool True if the user has liked the post, false otherwise.
     */
    public function doesUserHasLikedThisPost(int $user_id, int $post_id) : bool {
        $request = "SELECT * FROM $this->dbName";
        $request .= " WHERE USER_ID = $user_id AND POST_ID = $post_id;";
        $result = $this->conn->query($request);
        return !empty(mysqli_fetch_assoc($result));
    }

    /**
     * Count the number of likes on a specific post in the database.
     *
     * @param int $post_id
     * @return int The number of likes on the specified post.
     */
    public function countPostLike(int $post_id) : int {
        $request ="SELECT COUNT(*) nbLikes FROM $this->dbName";
        $request .= " WHERE POST_ID=$post_id;";
        return intval(mysqli_fetch_assoc($this->conn->query($request))["nbLikes"]);
    }

    /**
     * Add a user's like to a specific post in the database.
     *
     * @param int $user_id
     * @param int $post_id
     * @return bool True if the like was successfully added, false if the user has already liked the post.
     */
    public function addLike(int $user_id, int $post_id) : bool {
        if ($this->doesUserHasLikedThisPost($user_id, $post_id)) {
            return false; // This entry already exists
        }
        $request = "INSERT INTO $this->dbName (";
        $request .= "`" . implode("`, `", $this->dbColumns) . "`)";
        $request .= " VALUES ($user_id, $post_id);";
//        var_dump($request);
        $this->conn->query($request);
        return true;
    }

    /**
     * Remove a user's like from a specific post in the database.
     *
     * @param int $user_id
     * @param int $post_id
     * @return bool True if the like was successfully removed, false if the like entry doesn't exist in the table.
     */
    public function removeLike(int $user_id, int $post_id) : bool {
        if (!$this->doesUserHasLikedThisPost($user_id, $post_id)) {
            return false; // This entry doesn't exist
        }
        $query = "DELETE FROM $this->dbName WHERE USER_ID=$user_id AND POST_ID=$post_id";
        $this->conn->query($query);
        return true;
    }
}