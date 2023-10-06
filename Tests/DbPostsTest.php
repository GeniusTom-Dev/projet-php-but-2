<?php
include '../GFramework/database/Database.php';
include '../GFramework/database/dbPosts.php';
require '../GFramework/autoloader.php';

use PHPUnit\Framework\TestCase;

class DbPostsTest extends TestCase
{
    private $dbPosts = null;
    final public function getConnection(): dbPosts
    {
        if ($this->dbPosts == null) {
            $db = new Database('mysql-echo.alwaysdata.net','echo_mathieu','130304leroux','echo_bd_test');
            $dbConn = $db->getConnection()->getContent();
            $this->dbPosts = new dbPosts($dbConn);
        }
        return $this->dbPosts;
    }

    // -------------------------
    // FUNCTION TEST SELECT
    // -------------------------

    public function test_select_by_post_id() {
        $result = $this->getConnection()->selectByID(1)->getContent()["TITLE"];
        $this->assertEquals("Important", $result);
    }

    public function test_select_by_user_id() {
        $result = $this->getConnection()->selectByUserID(2)->getContent();
        $this->assertCount(3, $result);
        $this->assertEquals("Important", $result[0]["TITLE"]);
        $this->assertEquals("", $result[1]["TITLE"]);
        $this->assertEquals("...", $result[2]["TITLE"]);
    }

    public function test_select_by_like_title_or_content() {
        $result = $this->getConnection()->selectByLikeTitleOrContent("mot")->getContent();
        $this->assertCount(2, $result);
        $this->assertEquals("Important", $result[0]["TITLE"]);
        $this->assertEquals("un mot-clé", $result[1]["TITLE"]);
    }
}
