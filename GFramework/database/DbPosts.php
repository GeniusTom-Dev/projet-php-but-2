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

    public function getTotal()
    {
        $query = "SELECT COUNT(*) AS TOTAL FROM " . $this->dbName;
        return $this->conn->query($query)->fetch_assoc()['TOTAL'];
    }

    /*    public function convertSQLResultToAssocArray(GReturn $result) : GReturn{
            return new GReturn("ok", content: mysqli_fetch_all($result->getContent(), MYSQLI_ASSOC));
        }*/

    public function select_SQLResult(?string $contentOrTitleLike, ?int $user_id, ?string $dateMin, ?string $dateMax, ?int $limit = null, ?int $page = null, ?string $sort = null): GReturn
    {
        $request = "SELECT * FROM " . $this->dbName;
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
            $request .= " WHERE " . implode(" AND ", $conditions);
        }
        // Sorting result and limiting size for pagination
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

    public function selectByID(int $post_id): GReturn
    {
        $request = "SELECT * FROM $this->dbName";
        $request .= " WHERE POST_ID = '$post_id';";
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