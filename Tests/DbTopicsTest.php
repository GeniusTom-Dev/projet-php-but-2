<?php
include '../GFramework/database/Database.php';
include '../GFramework/database/DbTopics.php';
require '../GFramework/autoloader.php';

use PHPUnit\Framework\TestCase;

class DbTopicsTest extends TestCase { // En cour
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
    // FUNCTION TEST SELECT WITH FILTER
    // -------------------------

    public function test_select_by_id() {
        $result = $this->getConnection()->selectById("1")->getContent()["NAME"];
        $this->assertEquals('Sport', $result);
    }

    public function test_select_by_name() {
        $result = $this->getConnection()->selectByName("Cinema")->getContent()["TOPIC_ID"];
        $this->assertEquals(2, $result);
    }

    // -------------------------
    // FUNCTION TEST SELECT WITH FILTER
    // -------------------------


}
