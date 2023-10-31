<?php

use GFramework\utilities\GReturn;

class DbComments
{
    private string $dbName = "comments";

    private \mysqli $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getTotal()
    {
        $query = "SELECT COUNT(*) AS TOTAL FROM $this->dbName";
        return $this->conn->query($query)->fetch_assoc()['TOTAL'];
    }

    public function select_SQLResult(?int $post_id, ?int $user_id, ?string $contentLike, ?string $dateMin, ?string $dateMax, ?int $limit = null, ?int $page = null, ?string $sort = null): GReturn
    {
        $request = "SELECT * FROM $this->dbName";
        $conditions = [];
        if (!is_null($post_id)) {
            $conditions[] = "POST_ID = $post_id";
        }
        if (!is_null($user_id)) {
            $conditions[] = "USER_ID = $user_id";
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
            $request .= " WHERE " . implode(" AND ", $conditions);
        }
        // Sorting result and limiting result size for pagination
        $request .= " " . $this->getSortInstruction($sort);
        if (empty($limit) === false) {
            $request .= " LIMIT " . ($page - 1) * $limit . ", $limit";
        }

        $result = $this->conn->query($request);
        return new GReturn("ok", content: mysqli_fetch_all($result, MYSQLI_ASSOC));
    }

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

    public function addComment(int $post_id, int $user_id, string $content, string $date_posted): void
    {
        $resetIdMinValue = "ALTER TABLE $this->dbName AUTO_INCREMENT = 1;";
        $this->conn->query($resetIdMinValue);
        $request = "INSERT INTO $this->dbName (`POST_ID`, `USER_ID`, `CONTENT`, `DATE_POSTED`) VALUES ";
        $request .= "($post_id, $user_id, '$content', '$date_posted');";
        $this->conn->query($request);
    }

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

    public function deleteComment($id): void
    {
        $query = "DELETE FROM $this->dbName WHERE COMMENT_ID=$id";
        $this->conn->query($query);
    }
}