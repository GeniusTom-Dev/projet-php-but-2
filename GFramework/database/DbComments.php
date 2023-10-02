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

    public function select($id = null, $content = null, $datePosted = null, $post = null, $username = null) : GReturn{
        $result = $this->select_SQLResult($id, $content, $username, $datePosted)->getContent();
        $row = [];
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        }
        return new GReturn("ok", content: $row);
    }

    public function select_SQLResult($id = null, $content = null, $datePosted = null, $post = null, $username = null) : GReturn{
        $request = "SELECT * FROM " . $this->dbName;
        if(empty($id) === false){
            $request .= " WHERE COMMENT_ID=$id";
            if (empty($content) === false){
                $request .= " AND CONTENT='$content'";
            }
            if (empty($datePosted) === false){
                $request .= " AND DATE_POSTED='$datePosted'";
            }
            if (empty($post) === false){
                $request .= " AND POST_ID=$post";
            }
            if (empty($username) === false){
                $request .= " AND USER_ID='$username'";
            }
        }
        else if (empty($content) === false){
            $request .= " WHERE CONTENT='$content'";
            if (empty($datePosted) === false){
                $request .= " AND DATE_POSTED='$datePosted'";
            }
            if (empty($post) === false){
                $request .= " AND POST_ID=$post";
            }
            if (empty($username) === false){
                $request .= " AND USER_ID='$username'";
            }
        }
        else if (empty($datePosted) === false){
            $request .= " WHERE DATE_POSTED='$datePosted'";
            if (empty($post) === false){
                $request .= " AND POST_ID=$post";
            }
            if (empty($username) === false){
                $request .= " AND USER_ID='$username'";
            }
        }
        else if (empty($post) === false){
            $request .= " WHERE POST_ID=$post";
            if (empty($username) === false){
                $request .= " AND USER_ID='$username'";
            }
        }
        else if (empty($username) === false){
            $request .= " WHERE USER_ID='$username'";
        }
        $result = $this->conn->query($request);

        return new GReturn("ok", content: $result);
    }

    public function deleteComment($id): void{
        $query = "DELETE FROM " . $this->dbName . " WHERE COMMENT_ID=$id";
        $this->conn->query($query);
    }
}