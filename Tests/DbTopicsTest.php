<?php
include '../GFramework/database/Database.php';
include '../GFramework/database/DbTopics.php';
require '../GFramework/autoloader.php';

use PHPUnit\Framework\TestCase;

class DbTopicsTest extends TestCase { // Completed
    private DbTopics | null $dbTopics = null;
    final public function getConnection(): DbTopics
    {
        if ($this->dbTopics == null) {
            $db = new Database('mysql-echo.alwaysdata.net','echo_mathieu','130304leroux','echo_bd_test');
            $dbConn = $db->getConnection()->getContent();
            $this->dbTopics = new DbTopics($dbConn);
        }
        return $this->dbTopics;
    }

    // -------------------------
    // FUNCTION TEST SELECT
    // -------------------------

    public function test_select_by_id() {
        $result = $this->getConnection()->selectById("1")->getContent()["NAME"];
        var_dump($this->getConnection()->selectById("1")->getContent());
        $this->assertEquals('Sport', $result);
    }

    public function test_select_by_name() {
        $result = $this->getConnection()->selectByName("Musique")->getContent()["TOPIC_ID"];
        $this->assertEquals(2, $result);
    }

    // -------------------------
    // FUNCTION ADD-UPDATE-REMOVE
    // -------------------------

    public function test_add_a_topic() {
        $this->assertEquals(3, sizeof($this->getConnection()->select_SQLResult()->getContent()));
        $this->getConnection()->addTopic("Test", "A topic used for testing add, update and delete function");
        $this->assertEquals(4, sizeof($this->getConnection()->select_SQLResult()->getContent()));
    }

    public function test_update_a_topic() {
        $this->assertEquals("Test", $this->getConnection()->select_SQLResult("testing")->getContent()[0]["NAME"]);
        $this->getConnection()->changeTopic(4, "Test_2", "New description");
        $this->assertEquals("Test_2", $this->getConnection()->select_SQLResult("New description")->getContent()[0]["NAME"]);
        $this->assertEmpty($this->getConnection()->select_SQLResult("testing")->getContent());
    }

    public function test_delete_a_topic() {
        $this->assertEquals(4, sizeof($this->getConnection()->select_SQLResult()->getContent()));
        $this->getConnection()->deleteTopic(4);
        $this->assertEquals(3, sizeof($this->getConnection()->select_SQLResult()->getContent()));
    }
}
