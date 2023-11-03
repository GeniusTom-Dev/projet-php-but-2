<?php

use GFramework\utilities\GReturn;

/**
 * Singleton used to initialize the connection with the DbComments table and perform queries
 */
class DbComments
{
    private string $dbName = "comments";
    private mysqli $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    /**
     * Get the total number of comments based on optional filtering criteria.
     *
     * @param int|null $post_id (optional)
     * @param int|null $user_id (optional)
     * @param string|null $contentLike (optional)
     * @param string|null $dateMin (optional)
     * @param string|null $dateMax (optional)
     * @return int
     */
    public function getTotal(?int $post_id, ?int $user_id, ?string $contentLike, ?string $dateMin, ?string $dateMax) : int
    {
        $query = "SELECT COUNT(*) AS TOTAL FROM $this->dbName";
        // Filtering results
        $query .= " " . $this->getWhereInstruction($post_id, $user_id, $contentLike, $dateMin, $dateMax);
        return $this->conn->query($query)->fetch_assoc()['TOTAL'];
    }

    /**
     * Retrieve comments from the database based on optional filtering, sorting, and pagination criteria.
     *
     * @param int|null $post_id (optional)
     * @param int|string|null $user (optional) int = userId and string = usernameLike
     * @param string|null $contentLike (optional)
     * @param string|null $dateMin (optional)
     * @param string|null $dateMax (optional)
     * @param int|null $limit (optional)
     * @param int|null $page (optional)
     * @param string|null $sort (optional)
     * @return GReturn
     */
    public function select_SQLResult(?int $post_id=null, int|string|null $user=null, ?string $contentLike=null, ?string $dateMin=null, ?string $dateMax=null, ?int $limit = null, ?int $page = null, ?string $sort = null): GReturn
    {
        $request = "SELECT * FROM $this->dbName";
        if (is_string($user)) {
            $request .= " INNER JOIN users u ON " . $this->dbName . ".USER_ID=u.USER_ID";
        }
        // Filtering results
        $request .= " " . $this->getWhereInstruction($post_id, $user, $contentLike, $dateMin, $dateMax);
        // Sorting result and limiting result size for pagination
        $request .= " " . $this->getSortAndLimit($limit, $page, $sort);

        $result = $this->conn->query($request);
        return new GReturn("ok", content: mysqli_fetch_all($result, MYSQLI_ASSOC));
    }

    /**
     * Generate the WHERE clause for SQL queries based on optional filtering criteria.
     *
     * @param int|null $post_id (optional)
     * @param int|string|null $user (optional) int = userId and string = usernameLike
     * @param string|null $contentLike (optional)
     * @param string|null $dateMin (optional)
     * @param string|null $dateMax (optional)
     * @return string
     */
    public function getWhereInstruction(?int $post_id, int|string|null $user, ?string $contentLike, ?string $dateMin, ?string $dateMax): string{
        $conditions = [];
        if (!is_null($post_id)) {
            $conditions[] = "POST_ID = $post_id";
        }
        if (is_int($user)) {
            $conditions[] = "USER_ID = $user";
        } else if (is_string($user)) {
            $conditions[] = "u.USERNAME LIKE '$user%'";
        }
        if (!is_null($contentLike)) {
            $conditions[] = "CONTENT LIKE '%$contentLike%'";
        }
        if (!is_null($dateMin)) {
            $conditions[] = "DATE_POSTED >= '$dateMin'";
        }
        if (!is_null($dateMax)) {
            $conditions[] = "DATE_POSTED <= '$dateMax'";
        }
        if (!empty($conditions)) {
            $query = " WHERE " . implode(" AND ", $conditions);
        }
        else {
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
            return 'ORDER BY COMMENT_ID ASC';
        } else if ($sort == 'a-z') {
            return 'ORDER BY CONTENT ASC';
        } else if ($sort == 'recent') {
            return 'ORDER BY DATE_POSTED DESC';
        } else if ($sort == 'id-user') {
            return 'ORDER BY USER_ID ASC';
        } else if ($sort == 'id-post') {
            return 'ORDER BY POST_ID ASC';
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
     * Retrieve a specific comment from the database by its ID.
     *
     * @param int $comment_id
     * @return GReturn
     */
    public function selectByID(int $comment_id): GReturn
    {
        $request = "SELECT * FROM $this->dbName";
        $request .= " WHERE COMMENT_ID = $comment_id";
        $result = $this->conn->query($request);
        return new GReturn("ok", content: mysqli_fetch_assoc($result));
    }

    /**
     * Retrieve all comments from the database by their post id.
     *
     * @param int $post_id
     * @return array
     */
    public function getPostComments(int $post_id): array
    {
        $request = "SELECT * FROM $this->dbName";
        $request .= " WHERE POST_ID = $post_id";
        $result = $this->conn->query($request);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    /**
     * Add a new comment to the database.
     *
     * @param int $post_id
     * @param int $user_id
     * @param string $content
     * @param string $date_posted
     */
    public function addComment(int $post_id, int $user_id, string $content, string $date_posted): void
    {
        $resetIdMinValue = "ALTER TABLE $this->dbName AUTO_INCREMENT = 1;";
        $this->conn->query($resetIdMinValue);
        $request = "INSERT INTO $this->dbName (`POST_ID`, `USER_ID`, `CONTENT`, `DATE_POSTED`) VALUES ";
        $request .= "($post_id, $user_id, '$content', '$date_posted');";
        $this->conn->query($request);
    }

    /**
     * Update the content of a comment in the database.
     *
     * @param int $comment_id
     * @param string $newContent
     * @return bool True if the update was successful; false if the new content is empty.
     */
    public function updateComments(int $comment_id, string $newContent): bool
    {
        $request = "UPDATE $this->dbName";
        if (empty($newContent)) { // The content of a post can not be empty
            return false;
        }
        $request .= " SET CONTENT = '$newContent' WHERE COMMENT_ID = $comment_id;";
        $this->conn->query($request);
        return true;
    }

    /**
     * Delete a comment from the database by its ID.
     *
     * @param int $id
     */
    public function deleteComment(int $id): void
    {
        $query = "DELETE FROM $this->dbName WHERE COMMENT_ID=$id";
        $this->conn->query($query);
    }
}