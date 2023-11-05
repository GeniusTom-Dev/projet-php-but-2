<?php
use GFramework\utilities\GReturn;

class DbPostMedia
{
    private string $dbName = "post_media";
    private mysqli $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    /**
     * Get all images associated with a post based on its ID.
     *
     * @param int $postId
     * @return GReturn
     */
    public function getPostImages(int $postId) : GReturn {
        $request = "SELECT * FROM " . $this->dbName;
        $request .= " WHERE POST_ID=$postId;";
        $result = $this->conn->query($request);
        return new GReturn(state: "ok", content: mysqli_fetch_all($result, MYSQLI_ASSOC));
    }

    /**
     * Create an association between a post and an image url the database.
     *
     * @param int $postId
     * @param string $imgURL
     * @return void
     */
    public function addAnImageToPost(int $postId, string $imgURL) : void {
        $request = "INSERT INTO $this->dbName";
        $request .= " VALUES ($postId, '$imgURL');";
        $this->conn->query($request);
    }

    /**
     * Remove the association between an image url and a specific post in the database.
     *
     * @param int $postId
     * @param string $imgURL
     * @return void
     */
    public function removeAnImage(int $postId, string $imgURL) : void {
        $query = "DELETE FROM $this->dbName WHERE POST_ID=$postId AND IMAGE_URL='$imgURL'";
        $this->conn->query($query);
    }

    /**
     * Remove the association between a specific post and all associated images url in the database.
     *
     * @param int $postId
     * @return void
     */
    public function removeAllImages(int $postId) : void {
        $query = "DELETE FROM $this->dbName WHERE POST_ID=$postId";
        $this->conn->query($query);
    }
}