<?php

use GFramework\utilities\GReturn;

class DbPosts
{
    private string $dbName = "posts";
    private array | string $dbColumns = ["USER_ID", "TITLE", "CONTENT", "DATE_POSTED"];
    private mysqli $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function convertSQLResultToAssocArray(GReturn $result) : GReturn{
        return new GReturn("ok", content: mysqli_fetch_all($result->getContent(), MYSQLI_ASSOC));
    }

    public function select_SQLResult($titleLike = null, $contentLike = null, $user_id = null, $dateMin = null, $dateMax = null) : GReturn{
        $request = "SELECT * FROM  $this->dbName ";
        $conditions = [];
        if (!is_null($titleLike)) {
            $conditions[] = "TITLE LIKE %$titleLike%";
        }
        if (!is_null($contentLike)) {
            $conditions[] = "CONTENT LIKE %$contentLike%";
        }
        if (!is_null($user_id)) {
            $conditions[] = "USER_ID = $user_id";
        }
        if (!is_null($dateMin)) {
            $conditions[] = "DATE_POSTED >= $dateMin";
        }
        if (!is_null($dateMax)) {
            $conditions[] = "DATE_POSTED <= $dateMax";
        }
        if (!empty($conditions)) {
            $request .= "WHERE " . implode(" AND ", $conditions);
        }
        $result = $this->conn->query($request);
        return new GReturn("ok", content: $result);
    }

    public function selectByID(int $post_id) : GReturn {
        $request = "SELECT * FROM $this->dbName";
        $request .= " WHERE POST_ID = '$post_id';";
        $result = $this->conn->query($request);
        return new GReturn("ok", content: mysqli_fetch_assoc($result));
    }

    /* Add Post */

    public function addPost(int $user_id, string $title, string $content, string $date_posted) : bool {
        $resetIdMinValue = "ALTER TABLE $this->dbName AUTO_INCREMENT = 1;";
        $this->conn->query($resetIdMinValue);
        $request = "INSERT INTO $this->dbName (";
        $request .= "`" . implode("`, `", $this->dbColumns) . "`) VALUES (";
        $request .= "$user_id, '$title', '$content', '$date_posted');";
        $this->conn->query($request);
        return true;
    }

    /* Delete Post */

    public function deletePost($id): void{
        $query = "DELETE FROM " . $this->dbName . " WHERE POST_ID=$id";
        $this->conn->query($query);
    }
}