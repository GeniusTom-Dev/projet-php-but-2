<?php
use \GFramework\utilities\GReturn;

class dbComments
{
    private string $dbName = "comments";

    private \mysqli $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }


    public function select($id = null, $content = null, $datePosted = null, $idPost = null, $idUser = null) : GReturn{
        $result = $this->select_SQLResult($id, $content, $datePosted, $idPost, $idUser)->getContent();
        $row = [];
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        }
        return new GReturn("ok", content: $row);
    }

    public function select_SQLResult($id = null, $content = null, $datePosted = null, $idPost = null, $iduser = null) : GReturn{
        $request = "SELECT * FROM " . $this->dbName;
        if(empty($id) === false){
            $request .= " WHERE COMMENT_ID=$id";
            if (empty($content) === false){
                $request .= " AND CONTENT='$content'";
            }
            if (empty($datePosted) === false){
                $request .= " AND DATE_POSTED='$datePosted'";
            }
            if (empty($idPost) === false){
                $request .= " AND POST_ID=$idPost";
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
            if (empty($idPost) === false){
                $request .= " AND POST_ID=$idPost";
            }
            if (empty($username) === false){
                $request .= " AND USER_ID='$username'";
            }
        }
        else if (empty($datePosted) === false){
            $request .= " WHERE DATE_POSTED='$datePosted'";
            if (empty($idPost) === false){
                $request .= " AND POST_ID=$idPost";
            }
            if (empty($username) === false){
                $request .= " AND USER_ID='$username'";
            }
        }
        else if (empty($idPost) === false){
            $request .= " WHERE POST_ID=$idPost";
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