<?php

use \GFramework\utilities\GReturn;

class DbTopics
{
    private string $dbName = "topics";

    private \mysqli $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }
    public function getTotal(){
        $query = "SELECT COUNT(*) AS TOTAL FROM " . $this->dbName;
        return $this->conn->query($query)->fetch_assoc()['TOTAL'];
    }

    public function convertSQLResultToAssocArray(GReturn $result) : GReturn{
        return new GReturn("ok", content: mysqli_fetch_all($result->getContent(), MYSQLI_ASSOC));
    }

    public function select_SQLResult(?string $nameOrDescriptionLike, ?int $limit=null, ?int $page=null, ?string $sort=null) : GReturn{
        $request = "SELECT * FROM $this->dbName ";
        if (!is_null($nameOrDescriptionLike)) {
            $request .= "WHERE (NAME LIKE '%$nameOrDescriptionLike%' OR DESCRIPTION LIKE '%$nameOrDescriptionLike%')";
        }
        // Sorting result and limiting size for pagination
        if ($sort != null) {
            $request .= " " . $this->getSortInstruction($sort);
        }
        if (empty($limit) === false){
            $request .= " LIMIT " . ($page - 1) * $limit . ", $limit";
        }
        $request .= ";";
        $result = $this->conn->query($request);
        var_dump("REQUETE : $request");
        return new GReturn("ok", content: $result);
    }

    public function getSortInstruction(?string $sort): string{
        if ($sort == 'ID-asc'){
            return 'ORDER BY TOPIC_ID ASC';
        }
        else if ($sort == 'a-z'){
            return 'ORDER BY NAME ASC';
        }
        else if ($sort == 'recent'){
            return 'ORDER BY TOPIC_ID DESC';
        }
        return '';
    }

    public function selectById(int $topic_id) : GReturn {
        $request = "SELECT * FROM $this->dbName";
        $request .= " WHERE TOPIC_ID = $topic_id;";
        $result = $this->conn->query($request);
        return new GReturn("ok", content: mysqli_fetch_assoc($result));
    }

    public function selectByName(string $topic_name) : GReturn {
        $request = "SELECT * FROM $this->dbName";
        $request .= " WHERE NAME = '$topic_name';";
        $result = $this->conn->query($request);
        return new GReturn("ok", content: mysqli_fetch_assoc($result));
    }

    /* Update Topic */

    public function changeTopic($topic_id, $newName = null, $newDescription = null): bool {
        if (empty($newName) || $this->doesTopicAlreadyExist($newName)){
            return False; // the modification was not made
        }
        $query = "UPDATE $this->dbName SET NAME='$newName', DESCRIPTION='$newDescription' WHERE TOPIC_ID='$topic_id'";
        $this->conn->query($query);
        return True; // the modification was made
    }

    /* Add Topic */

    public function addTopic($name, $Description): bool {
        if (empty($name) || $this->doesTopicAlreadyExist($name)) {
            return false;
        }
        $resetIdMinValue = "ALTER TABLE $this->dbName AUTO_INCREMENT = 1;";
        $this->conn->query($resetIdMinValue);
        $query = "INSERT INTO $this->dbName (`NAME`, `DESCRIPTION`) VALUES ('$name', '$Description');";
        $this->conn->query($query);
        return true;
    }

    /* Delete Topic */

    public function deleteTopic($id): void{
        $query = "DELETE FROM $this->dbName WHERE TOPIC_ID = $id";
        $this->conn->query($query);
    }

    /* check if already exists functions */

    private function doesTopicAlreadyExist(string $name) : bool {
        $request = "SELECT * FROM $this->dbName WHERE NAME = '$name'";
        return !empty(mysqli_fetch_assoc($this->conn->query($request)));
    }

}