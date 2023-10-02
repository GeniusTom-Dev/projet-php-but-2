<?php

use \GFramework\utilities\GReturn;

class dbPosts
{
    private string $dbName = "posts";

    private \mysqli $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }


    public function select(?int $id = null, ?string $title = null, ?string $content = null, ?int $idUser = null, ?string $datePosted = null, ?int $limit = null, int $page = 0, ?string $sort = null) : GReturn{
        $result = $this->select_SQLResult($id, $title, $content, $idUser, $datePosted, $limit, $page, $sort)->getContent();
        $row = [];
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        }
        return new GReturn("ok", content: $row);
    }

    public function select_SQLResult(?int $id = null, ?string $title = null, ?string $content = null, ?int $idUser = null, ?string $datePosted = null, ?int $limit = null, int $page = 0, ?string $sort = null) : GReturn{
        $request = "SELECT * FROM " . $this->dbName;
        if(empty($id) === false){
            $request .= " WHERE POST_ID=$id";
            if (empty($title) === false){
                $request .= " AND TITLE='$title'";
            }
            if (empty($content) === false){
                $request .= " AND CONTENT='$content'";
            }
            if (empty($username) === false){
                $request .= " AND USER_ID=$idUser";
            }
            if (empty($datePosted) === false){
                $request .= " AND DATE_POSTED='$datePosted'";
            }
        }
        else if (empty($title) === false){
            $request .= " WHERE TITLE='$title'";
            if (empty($content) === false){
                $request .= " AND CONTENT='$content'";
            }
            if (empty($username) === false){
                $request .= " AND USER_ID='$username'";
            }
            if (empty($datePosted) === false){
                $request .= " AND DATE_POSTED='$datePosted'";
            }
        }
        else if (empty($content) === false){
            $request .= " WHERE CONTENT='$content'";
            if (empty($username) === false){
                $request .= " AND USER_ID='$username'";
            }
            if (empty($datePosted) === false){
                $request .= " AND DATE_POSTED='$datePosted'";
            }
        }
        else if (empty($username) === false){
            $request .= " WHERE USER_ID='$username'";
            if (empty($datePosted) === false){
                $request .= " AND DATE_POSTED='$datePosted'";
            }
        }
        else if (empty($datePosted) === false){
            $request .= " WHERE DATE_POSTED='$datePosted'";
        }
        if (empty($limit) === false){
            $request .= " LIMIT " . $limit;
        }
        $request .= " " . $this->getSortInstruction($sort);
        $result = $this->conn->query($request);
        return new GReturn("ok", content: $result);
    }

    public function getSortInstruction(?string $sort): string{
        if ($sort == 'ID-asc'){
            return 'ORDER BY POST_ID ASC';
        }
        else if ($sort == 'a-z'){
            return 'ORDER BY TITLE ASC';
        }
        else if ($sort == 'recent'){
            return 'ORDER BY DATE_POSTED DESC';
        }
        else if ($sort == 'id-user'){
            return 'ORDER BY USER_ID ASC';
        }
        return '';
    }

    public function deletePost(int $id): void{
        $query = "DELETE FROM " . $this->dbName . " WHERE POST_ID=$id";
        $this->conn->query($query);
    }

}