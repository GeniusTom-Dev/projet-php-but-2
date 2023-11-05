<?php

namespace GFramework\database;


use GFramework\utilities\GReturn;
use mysqli;

class DbBelongsTo
{
    private string $dbName = "belongs_to";
    private mysqli $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    /**
     * Get all topics associated with a post based on its ID.
     *
     * @param int $postId
     * @return GReturn
     */
    public function getAllTopicsOfAPost(int $postId): GReturn
    {
        $request = "SELECT * FROM " . $this->dbName;
        $request .= " WHERE POST_ID=$postId;";
        $result = $this->conn->query($request);
        return new GReturn(state: "ok", content: mysqli_fetch_all($result, MYSQLI_ASSOC));
    }

    /**
     * Create an association between a post and a topic the databse.
     *
     * @param int $postId
     * @param int $topicId
     * @return void
     */
    public function addATopicToAPost(int $postId, int $topicId): void
    {
        $request = "INSERT INTO $this->dbName";
        $request .= " VALUES ($postId, $topicId);";
        $this->conn->query($request);
    }

    /**
     * Remove the association between a topic and a specific post in the database.
     *
     * @param int $postId
     * @param int $topicId
     * @return void
     */
    public function removeATopic(int $postId, int $topicId): void
    {
        $query = "DELETE FROM $this->dbName WHERE POST_ID=$postId AND TOPIC_ID=$topicId";
        $this->conn->query($query);
    }
}