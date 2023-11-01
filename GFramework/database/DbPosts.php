<?php

use GFramework\utilities\GReturn;

class DbPosts
{
    private string $dbName = "posts";
    private array|string $dbColumns = ["USER_ID", "TITLE", "CONTENT", "DATE_POSTED"];
    private mysqli $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getTotal(?string $contentOrTitleLike, ?int $user_id, ?string $dateMin, ?string $dateMax)
    {
        $query = "SELECT COUNT(*) AS TOTAL FROM " . $this->dbName;
        // Filtering results
        $query .= " " . $this->getWhereInstruction($contentOrTitleLike, $user_id, $dateMin, $dateMax);
        return $this->conn->query($query)->fetch_assoc()['TOTAL'];
    }

    public function select_SQLResult(?string $contentOrTitleLike, ?int $user_id, ?string $dateMin, ?string $dateMax, ?int $limit = null, ?int $page = null, ?string $sort = null): GReturn
    {
        $request = "SELECT * FROM " . $this->dbName;
        // Filtering results
        $request .= " " . $this->getWhereInstruction($contentOrTitleLike, $user_id, $dateMin, $dateMax);
        // Sorting result and limiting size for pagination
        $request .= " " . $this->getSortAndLimit($limit, $page, $sort);

        $result = $this->conn->query($request);
        return new GReturn("ok", content: mysqli_fetch_all($result, MYSQLI_ASSOC));
    }

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

    public function selectByID(int $post_id, ?int $limit = null, ?int $page = null, ?string $sort = null): GReturn
    {
        $request = "SELECT * FROM $this->dbName";
        $request .= " WHERE POST_ID = '$post_id' ";
        // Sorting result and limiting size for pagination
        $request .= $this->getSortAndLimit($limit, $page, $sort);

        $result = $this->conn->query($request);
        return new GReturn("ok", content: mysqli_fetch_assoc($result));
    }

    /* Delete Post */

    public function deletePost($id): void
    {
        $query = "DELETE FROM " . $this->dbName . " WHERE POST_ID=$id";
        $this->conn->query($query);
    }

    /* Add Post */

    public function addPost(int $user_id, string $title, string $content, string $date_posted): bool
    {
        // check if the user exist ?
        $resetIdMinValue = "ALTER TABLE $this->dbName AUTO_INCREMENT = 1;";
        $this->conn->query($resetIdMinValue);
        $request = "INSERT INTO $this->dbName (";
        $request .= "`" . implode("`, `", $this->dbColumns) . "`) VALUES (";
        $request .= "$user_id, '$title', '$content', '$date_posted');";
        $this->conn->query($request);
        return true;
    }

    /* Update Post */

    public function updateTitleAndContent(int $post_id, string $title, string $content)
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
}