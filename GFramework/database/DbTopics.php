<?php

namespace GFramework\database;

use GFramework\utilities\GReturn;
use mysqli;

/**
 * Singleton used to initialize the connection with the DbTopics table and perform queries
 */
class DbTopics
{
    private string $dbName = "topics";
    private mysqli $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    /**
     * Get the total number of topics based on optional filtering criteria.
     *
     * @param string|null $nameOrDescriptionLike (optional)
     * @return int
     */
    public function getTotal(?string $nameOrDescriptionLike = null): int
    {
        $query = "SELECT COUNT(*) AS TOTAL FROM " . $this->dbName;
        if ($nameOrDescriptionLike != null) {
            $query .= " WHERE (NAME LIKE '%$nameOrDescriptionLike%' OR DESCRIPTION LIKE '%$nameOrDescriptionLike%')";
        }
        return $this->conn->query($query)->fetch_assoc()['TOTAL'];
    }

    /**
     * Retrieve topics from the database based on optional filtering, sorting, and pagination criteria.
     *
     * @param string|null $nameOrDescriptionLike (optional)
     * @param int|null $limit (optional)
     * @param int|null $page (optional)
     * @param string|null $sort (optional)
     * @return GReturn
     */
    public function select_SQLResult(?string $nameOrDescriptionLike = null, ?int $limit = null, ?int $page = null, ?string $sort = null): GReturn
    {
        $request = "SELECT * FROM $this->dbName ";
        if (!is_null($nameOrDescriptionLike)) {
            $request .= "WHERE (NAME LIKE '%$nameOrDescriptionLike%' OR DESCRIPTION LIKE '%$nameOrDescriptionLike%')";
        }
        // Sorting result and limiting size for pagination
        $request .= $this->getSortAndLimit($limit, $page, $sort);

        $request .= ";";
        $result = $this->conn->query($request);
        return new GReturn("ok", content: mysqli_fetch_all($result, MYSQLI_ASSOC));
    }

    /**
     * Generate an SQL sorting instruction based on the specified sorting option.
     *
     * @param string|null $sort (optional)
     * @return string
     */
    public function getSortInstruction(?string $sort): string
    {
        if ($sort == 'ID-asc') {
            return 'ORDER BY TOPIC_ID ASC';
        } else if ($sort == 'a-z') {
            return 'ORDER BY NAME ASC';
        } else if ($sort == 'recent') {
            return 'ORDER BY TOPIC_ID DESC';
        }
        return '';
    }

    /**
     * Generate SQL sorting and pagination instructions based on optional parameters.
     *
     * @param int|null $limit (optional)
     * @param int|null $page (optional)
     * @param string|null $sort (optional)
     * @return string
     */
    public function getSortAndLimit(?int $limit, ?int $page, ?string $sort): string
    {
        $request = '';
        if ($sort != null) {
            $request .= " " . $this->getSortInstruction($sort);
        }
        if ($limit != null && $page != null) {
            $request .= " LIMIT " . ($page - 1) * $limit . ", $limit";
        }
        return $request;
    }

    /**
     * Retrieve a specific topic from the database by its ID.
     *
     * @param int $topic_id
     * @return GReturn
     */
    public function selectById(int $topic_id): GReturn
    {
        $request = "SELECT * FROM $this->dbName";
        $request .= " WHERE TOPIC_ID = $topic_id";
        $request .= ";";
        $result = $this->conn->query($request);
        return new GReturn("ok", content: mysqli_fetch_assoc($result));
    }

    /**
     * Retrieve a specific topic from the database by its Name.
     *
     * @param string $topic_name
     * @return GReturn
     */
    public function selectByName(string $topic_name): GReturn
    {
        $request = "SELECT * FROM $this->dbName";
        $request .= " WHERE NAME = '$topic_name'";
        $request .= ";";
        $result = $this->conn->query($request);
        return new GReturn("ok", content: mysqli_fetch_assoc($result));
    }

    /**
     * Add a new topic to the database.
     *
     * @param $name
     * @param $Description
     * @return bool True if the update was successful; false if a topic with this name already exists
     */
    public function addTopic($name, $Description): bool
    {
        if (empty($name) || $this->doesTopicAlreadyExist($name)) {
            return false;
        }
        $resetIdMinValue = "ALTER TABLE $this->dbName AUTO_INCREMENT = 1;";
        $this->conn->query($resetIdMinValue);
        $query = "INSERT INTO $this->dbName (`NAME`, `DESCRIPTION`) VALUES ('$name', '$Description');";
        $this->conn->query($query);
        return true;
    }

    /**
     * Update a topic in the database.
     *
     * @param int $topic_id
     * @param string $newName
     * @param string|null $newDescription (optional)
     * @return bool True if the update was successful; false if a topic with this name already exists or if the new content is empty.
     */
    public function changeTopic(int $topic_id, string $newName, ?string $newDescription = null): bool
    {
        if (empty($newName) || $this->doesTopicAlreadyExist($newName)) {
            return False; // the modification was not made
        }
        $query = "UPDATE $this->dbName SET NAME='$newName', DESCRIPTION='$newDescription' WHERE TOPIC_ID='$topic_id'";
        $this->conn->query($query);
        return True; // the modification was made
    }

    /**
     * Delete a topic from the database by its ID.
     *
     * @param $id
     * @return void
     */
    public function deleteTopic($id): void
    {
        $query = "DELETE FROM $this->dbName WHERE TOPIC_ID = $id";
        $this->conn->query($query);
    }

    /**
     * Check if a topic with a specific name already exists in the database.
     *
     * @param string $name
     * @return bool True if a topic with the specified name already exists, false otherwise.
     */
    private function doesTopicAlreadyExist(string $name): bool
    {
        $request = "SELECT * FROM $this->dbName WHERE NAME = '$name'";
        return !empty(mysqli_fetch_assoc($this->conn->query($request)));
    }

}