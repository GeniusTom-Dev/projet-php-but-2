<?php
use \GFramework\utilities\GReturn;

class dbComments
{
    private string $dbName = "comments";

    private \mysqli $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }


    public function select(?int $id = null, ?string $content = null, ?string $datePosted = null, ?int $idPost = null, ?int $idUser = null, ?int $limit = null, int $page = 0, ?string $sort = null) : GReturn{
        $result = $this->select_SQLResult($id, $content, $datePosted, $idPost, $idUser, $limit, $page, $sort)->getContent();
        $row = [];
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        }
        return new GReturn("ok", content: $row);
    }

    public function select_SQLResult(?int $id = null, ?string $content = null, ?string $datePosted = null, ?int $idPost = null, ?int $idUser = null, ?int $limit = null, int $page = 0, ?string $sort = null) : GReturn{
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
                $request .= " AND USER_ID=$idUser";
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
                $request .= " AND USER_ID=$idUser";
            }
        }
        else if (empty($datePosted) === false){
            $request .= " WHERE DATE_POSTED='$datePosted'";
            if (empty($idPost) === false){
                $request .= " AND POST_ID=$idPost";
            }
            if (empty($username) === false){
                $request .= " AND USER_ID=$idUser";
            }
        }
        else if (empty($idPost) === false){
            $request .= " WHERE POST_ID=$idPost";
            if (empty($username) === false){
                $request .= " AND USER_ID=$idUser";
            }
        }
        else if (empty($username) === false){
            $request .= " WHERE USER_ID=$idUser";
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
            return 'ORDER BY COMMENT_ID ASC';
        }
        else if ($sort == 'a-z'){
            return 'ORDER BY CONTENT ASC';
        }
        else if ($sort == 'recent'){
            return 'ORDER BY DATE_POSTED DESC';
        }
        else if ($sort == 'id-user'){
            return 'ORDER BY USER_ID ASC';
        }
        else if ($sort == 'id-post'){
            return 'ORDER BY POST_ID ASC';
        }
        return '';
    }

    public function deleteComment($id): void{
        $query = "DELETE FROM " . $this->dbName . " WHERE COMMENT_ID=$id";
        $this->conn->query($query);
    }
}