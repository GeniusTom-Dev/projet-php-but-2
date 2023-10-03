<?php
use \GFramework\utilities\GReturn;

class DbComments
{
    private string $dbName = "comments";

    private \mysqli $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    public function addComment():void{

    }

    public function convertSQLResultToAssocArray(GReturn $result) : GReturn{
        return new GReturn("ok", content: mysqli_fetch_all($result->getContent(), MYSQLI_ASSOC));
    }

    public function select_SQLResult($user_id = null, $contentLike = null, $post_id = null, $dateMin = null, $dateMax = null) : GReturn{
        $request = "SELECT * FROM  $this->dbName ";
        $conditions = [];
        if (!is_null($user_id)) {
            $conditions[] = "USER_ID = $user_id";
        }
        if (!is_null($contentLike)) {
            $conditions[] = "CONTENT LIKE %$contentLike%";
        }
        if (!is_null($post_id)) {
            $conditions[] = "POST_ID = $post_id";
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

    public function deleteComment($id): void{
        $query = "DELETE FROM $this->dbName WHERE COMMENT_ID = $id";
        $this->conn->query($query);
    }
}