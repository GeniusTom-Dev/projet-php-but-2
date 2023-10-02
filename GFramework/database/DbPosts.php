<?php

use \GFramework\utilities\GReturn;

class DbPosts
{
    private string $dbName = "posts";

    private \mysqli $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }


    public function select($id = null, $title = null, $content = null, $username = null, $datePosted = null) : GReturn{
        $result = $this->select_SQLResult($id, $title, $content, $username, $datePosted)->getContent();
        $row = [];
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        }
        return new GReturn("ok", content: $row);
    }

    public function select_SQLResult($id = null, $title = null, $content = null, $username = null, $datePosted = null) : GReturn{
        $request = "SELECT * FROM " . $this->dbName;
        if(empty($id) === false){
            $request .= " WHERE POST_ID = $id";
            if (empty($title) === false){
                $request .= " AND TITLE = '$title'";
            }
            if (empty($content) === false){
                $request .= " AND CONTENT = '$content'";
            }
            if (empty($username) === false){
                $request .= " AND USER_ID = '$username'";
            }
            if (empty($datePosted) === false){
                $request .= " AND DATE_POSTED = '$datePosted'";
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
        $result = $this->conn->query($request);

        return new GReturn("ok", content: $result);
    }

    public function deletePost($id): void{
        $query = "DELETE FROM " . $this->dbName . " WHERE POST_ID=$id";
        $this->conn->query($query);
    }

    // ----- Temporaire

    /**
     * @param int $post_id
     * @return GReturn
     * Use to get a posts information from his ID
     */
    public function selectByID(int $post_id) : GReturn {
        $request = "SELECT * FROM $this->dbName";
        $request .= " WHERE POST_ID = '$post_id';";
        $result = $this->conn->query($request);
        return new GReturn("ok", content: mysqli_fetch_assoc($result));
    }

    /**
     * @param int $user_id
     * @return GReturn
     * Use to get all the posts of a user from his ID
     */
    public function selectByUserID(int $user_id) : GReturn {
        $request = "SELECT * FROM $this->dbName";
        $request .= " WHERE USER_ID = '$user_id';";
        $result = $this->conn->query($request);
        return new GReturn("ok", content: mysqli_fetch_all($result, MYSQLI_ASSOC));
    }

    public function selectByLikeTitleOrContent(string $text, bool $searchOnlyInTitle = false) : GReturn {
        $request = "SELECT * FROM $this->dbName";
        $request .= " WHERE TITLE LIKE '%$text%'";
        if (!$searchOnlyInTitle) {
            $request .= " OR CONTENT LIKE '%$text%';";
        }
        $result = $this->conn->query($request);
        return new GReturn("ok", content: mysqli_fetch_all($result, MYSQLI_ASSOC));
    }
}