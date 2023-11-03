<?php
include '../GFramework/database/Database.php';
include '../GFramework/database/DbBelongsTo.php';
require '../GFramework/autoloader.php';

use PHPUnit\Framework\TestCase;

class DbBelongsToTest extends TestCase
{
    private DbBelongsTo|null $dbBelongsTo = null;

    final public function getConnection(): \DbBelongsTo
    {
        if ($this->dbBelongsTo== null) {
            $db = new Database('mysql-echo.alwaysdata.net', 'echo_mathieu', '130304leroux', 'echo_bd_test');
            $dbConn = $db->getConnection()->getContent();
            $this->dbBelongsTo = new DbBelongsTo($dbConn);
        }
        return $this->dbBelongsTo;
    }

    public function test_add_topic() {
        $this->assertEquals(2, sizeof($this->getConnection()->getAllTopicsOfAPost(1)->getContent()));
        $this->getConnection()->addATopicToAPost(1,3);
        $this->assertEquals(3, sizeof($this->getConnection()->getAllTopicsOfAPost(1)->getContent()));
    }

    public function test_remove_topic() {
        $this->assertEquals(3, sizeof($this->getConnection()->getAllTopicsOfAPost(1)->getContent()));
        $this->getConnection()->removeATopic(1,3);
        $this->assertEquals(2, sizeof($this->getConnection()->getAllTopicsOfAPost(1)->getContent()));
    }
}
