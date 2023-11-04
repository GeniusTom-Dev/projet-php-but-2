<?php

use GFramework\utilities\GReturn;

/**
 * Singleton used to initialize the connection with the DbFavorites table and perform queries
 */
class DbFavorites
{
    private string $dbName = "favorites";
    private mysqli $conn;
    public function __construct($conn){
        $this->conn = $conn;
    }

    /**
     * Check if a user has favorited a specific post in the database.
     *
     * @param int $user_id
     * @param int $post_id
     * @return bool True if the user has favorited the post, false otherwise.
     */
    public function doesUserHaveFavoritedThisPost(int $user_id, int $post_id) : bool {
        $request = "SELECT * FROM $this->dbName";
        $request .= " WHERE USER_ID = $user_id AND POST_ID = $post_id;";
        $result = $this->conn->query($request);
        return !empty(mysqli_fetch_assoc($result));
    }

    /**
     * Add a user's favorite association to a post in the database.
     *
     * @param int $user_id
     * @param int $post_id
     * @return bool True if the favorite association was successfully added, false if the user has already favorited the post.
     */
    public function addFavorite(int $user_id, int $post_id) : bool {
        if ($this->doesUserHaveFavoritedThisPost($user_id, $post_id)) {
            return false; // Modification was not made
        }
        $request = "INSERT INTO $this->dbName (`POST_ID`, `USER_ID`) VALUES ";
        $request .= "($post_id, $user_id);";
        $this->conn->query($request);
        return true;
    }

    /**
     * Remove a user's favorite association from a post in the database.
     *
     * @param int $user_id
     * @param int $post_id
     * @return bool True if the favorite association was successfully removed, false if the association doesn't exist in the table.
     */
    public function removeFavorite(int $user_id, int $post_id) : bool {
        if (!$this->doesUserHaveFavoritedThisPost($user_id, $post_id)) {
            return false; // This entry doesn't exist in the table
        }
        $query = "DELETE FROM $this->dbName WHERE USER_ID=$user_id AND POST_ID=$post_id";
        $this->conn->query($query);
        return true;
    }

    public function getUserFavoritePostsID(int $userID, ?int $limit, ?int $page, ?string $sort){
        $request = "SELECT POST_ID FROM $this->dbName";
        $request .= " WHERE USER_ID = $userID ";
        $request .= $this->getSortAndLimit($limit, $page, $sort);
        $result = $this->conn->query($request);
        return new GReturn("ok", content: mysqli_fetch_all($result, MYSQLI_ASSOC));
    }

    /**
     * Generate an SQL sorting instruction based on the specified sorting option.
     *
     * @param string|null $sort (optional)
     * @return string
     */
    public function getSortInstruction(?string $sort): string
    {
        if ($sort == 'ID-User-asc') {
            return 'ORDER BY USER_ID ASC';
        } else if ($sort == 'ID-Post-asc') {
            return 'ORDER BY POST_ID ASC';
        } else if ($sort == 'recent') {
            return 'ORDER BY POST_ID DESC';
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


}




















