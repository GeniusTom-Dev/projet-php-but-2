<?php

use GFramework\utilities\GReturn;

/**
 * Singleton used to initialize the connection with the DbPosts table and perform queries
 */
class DbPosts
{
    private string $dbName = "posts";
    private array|string $dbColumns = ["USER_ID", "TITLE", "CONTENT", "DATE_POSTED"];
    private mysqli $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    /**
     * Get the total number of posts based on optional filtering criteria.
     *
     * @param string|null $contentOrTitleLike
     * @param int|null $user_id
     * @param string|null $dateMin
     * @param string|null $dateMax
     * @return int
     */
    public function getTotal(?string $contentOrTitleLike, ?int $user_id, ?string $dateMin, ?string $dateMax)
    {
        $query = "SELECT COUNT(*) AS TOTAL FROM " . $this->dbName;
        // Filtering results
        $query .= " " . $this->getWhereInstruction($contentOrTitleLike, $user_id, $dateMin, $dateMax);
        return $this->conn->query($query)->fetch_assoc()['TOTAL'];
    }

    /**
     * Retrieve posts from the database based on optional filtering, sorting, and pagination criteria.
     *
     * @param string|null $contentOrTitleLike (optional)
     * @param int|null $user_id (optional)
     * @param string|null $dateMin (optional)
     * @param string|null $dateMax (optional)
     * @param int|null $limit (optional)
     * @param int|null $page (optional)
     * @param string|null $sort (optional)
     * @return GReturn
     */
    public function select_SQLResult(?int $topicId=null, ?string $contentOrTitleLike=null, ?int $user_id=null, ?string $dateMin=null, ?string $dateMax=null, ?int $limit = null, ?int $page = null, ?string $sort = null): GReturn
    {
        $request = "SELECT * FROM " . $this->dbName;
        // Filtering results
        $request .= " " . $this->getWhereInstruction($contentOrTitleLike, $user_id, $dateMin, $dateMax);
        // Sorting result and limiting size for pagination
        $request .= " " . $this->getSortAndLimit($limit, $page, $sort);

        $result = $this->conn->query($request);
        return new GReturn("ok", content: mysqli_fetch_all($result, MYSQLI_ASSOC));
    }

    /**
     * Generate the WHERE clause for SQL queries based on optional filtering criteria.
     *
     * @param string|null $contentOrTitleLike (optional)
     * @param int|null $user_id (optional)
     * @param string|null $dateMin (optional)
     * @param string|null $dateMax (optional)
     * @return string
     */
    public function getWhereInstruction(?string $contentOrTitleLike, ?int $user_id, ?string $dateMin, ?string $dateMax): string{
        $conditions = [];
        if (!is_null($contentOrTitleLike)) {
            $conditions[] = "(TITLE LIKE '%$contentOrTitleLike%' OR CONTENT LIKE '%$contentOrTitleLike%')";
        }
        if (!is_null($user_id)) {
            $conditions[] = "USER_ID = $user_id";
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
        else{
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
            return 'ORDER BY POST_ID ASC';
        } else if ($sort == 'a-z') {
            return 'ORDER BY TITLE ASC';
        } else if ($sort == 'recent') {
            return 'ORDER BY DATE_POSTED DESC';
        } else if ($sort == 'id-user') {
            return 'ORDER BY USER_ID ASC';
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
     * Retrieve a specific post from the database by its ID.
     *
     * @param int $post_id
     * @return GReturn
     */
    public function selectByID(int $post_id): GReturn
    {
        $request = "SELECT * FROM $this->dbName";
        $request .= " WHERE POST_ID = '$post_id' ";
        $result = $this->conn->query($request);
        return new GReturn("ok", content: mysqli_fetch_assoc($result));
    }

    /**
     * Add a new post to the database.
     *
     * @param int $user_id
     * @param string $title
     * @param string $content
     * @param string $date_posted
     * @return void
     */
    public function addPost(int $user_id, string $title, string $content, string $date_posted): void
    {
        // check if the user exist ?
        $resetIdMinValue = "ALTER TABLE $this->dbName AUTO_INCREMENT = 1;";
        $this->conn->query($resetIdMinValue);
        $request = "INSERT INTO $this->dbName (";
        $request .= "`" . implode("`, `", $this->dbColumns) . "`) VALUES (";
        $request .= "$user_id, '$title', '$content', '$date_posted');";
        $this->conn->query($request);
    }

    /**
     * Update the content of a post in the database.
     *
     * @param int $post_id
     * @param string $title
     * @param string $content
     * @return bool True if the update was successful; false if the new content is empty.
     */
    public function updateTitleAndContent(int $post_id, string $title, string $content) : bool
    {
        $request = "UPDATE $this->dbName";
        if (empty($title)) {
            $request .= " SET TITLE = NULL";
        } else {
            $request .= " SET TITLE = '$title'";
        }
        if (empty($content)) {
            // The content of a post can not be empty
            return false;
        } else {
            $request .= ", CONTENT = '$content'";
        }
        $request .= " WHERE POST_ID = '$post_id';";
        $this->conn->query($request);
        return true;
    }

    /**
     * Delete a post from the database by its ID.
     *
     * @param $id
     * @return void
     */
    public function deletePost($id): void
    {
        $query = "DELETE FROM " . $this->dbName . " WHERE POST_ID=$id";
        $this->conn->query($query);
    }
}