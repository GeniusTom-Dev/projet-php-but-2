<?php
use GFramework\utilities\GReturn;

class DbBelongsTo
{
    private string $dbName = "belongs_to";

    private mysqli $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllTopicsOfAPost(int $postId) {
        $request = "SELECT * FROM " . $this->dbName;
        $request .= " WHERE POST_ID=$postId;";
        $result = $this->conn->query($request);
        return new GReturn(state: "ok", content: mysqli_fetch_all($result, MYSQLI_ASSOC));
    }

    public function addATopicToAPost(int $postId, int $topicId) {
        $request = "INSERT INTO $this->dbName";
        $request .= " VALUES ($postId, $topicId);";
        var_dump($request);
        $this->conn->query($request);
        return true;
    }

    public function removeATopic(int $postId, int $topicId) : bool {
        $query = "DELETE FROM $this->dbName WHERE POST_ID=$postId AND TOPIC_ID=$topicId";
        $this->conn->query($query);
        return true;
    }
}