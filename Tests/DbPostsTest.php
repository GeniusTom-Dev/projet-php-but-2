<?php
include '../GFramework/database/Database.php';
include '../GFramework/database/DbPosts.php';
require '../GFramework/autoloader.php';

use PHPUnit\Framework\TestCase;

class DbPostsTest extends TestCase { // Completed
    private DbPosts|null $dbPosts = null;
    final public function getConnection(): DbPosts
    {
        if ($this->dbPosts == null) {
            $db = new Database('mysql-echo.alwaysdata.net','echo_mathieu','130304leroux','echo_bd_test');
            $dbConn = $db->getConnection()->getContent();
            $this->dbPosts = new DbPosts($dbConn);
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
        $result = $this->getConnection()->select_SQLResult(null, null, 2)->getContent();
        $this->assertCount(3, $result);
        $this->assertEquals("Important", $result[0]["TITLE"]);
        $this->assertEquals("", $result[1]["TITLE"]);
        $this->assertEquals("...", $result[2]["TITLE"]);
    }

    public function test_select_by_topic() {
        $result = $this->getConnection()->select_SQLResult(2)->getContent();
        $this->assertCount(2, $result);
        $this->assertEquals(1, $result[0]["POST_ID"]);
        $this->assertEquals(3, $result[1]["POST_ID"]);
    }

    public function test_select_by_like_title_or_content() {
        $result = $this->getConnection()->select_SQLResult(null, "mot")->getContent();
        $this->assertCount(2, $result);
        $this->assertEquals(1, $result[0]["POST_ID"]);
        $this->assertEquals(3, $result[1]["POST_ID"]);
    }

    public function test_select_by_like_date() {
        $result = $this->getConnection()->select_SQLResult(null, null, null, '2023-10-01', '2023-10-06')->getContent();
        $this->assertCount(3, $result);
    }

    public function test_select_by_like_date_2() {
        $result = $this->getConnection()->select_SQLResult(null,null, null, '2021-10-01', '2022-10-06')->getContent();
        $this->assertCount(0, $result);
    }

    public function test_select_many_filter() {
        $result = $this->getConnection()->select_SQLResult(null, "rand", 2, '2023-09-28', '2023-10-06')->getContent();
        $this->assertCount(1, $result);
        $this->assertEquals(2, $result[0]["POST_ID"]);
    }

    // -------------------------
    // FUNCTION TEST ADD
    // -------------------------

    public function test_add() {
        $this->getConnection()->addPost(3, "Un Titre", "Un Contenu", "2023-10-06");
        $checkIfWasAdd = $this->getConnection()->select_SQLResult(null, "un Titre", 3, "2023-10-06", "2023-10-06")->getContent();
        $this->assertNotEmpty($checkIfWasAdd);
    }

    // -------------------------
    // FUNCTION TEST UPDATE
    // -------------------------

    public function test_update_title_and_content() {
        $this->getConnection()->updateTitleAndContent(6, "Un Nouveau Titre", "Un Nouveau Contenue");
        $checkIfWasUpdated = $this->getConnection()->select_SQLResult(null, "un Nouveau Titre", 3, "2023-10-06", "2023-10-06")->getContent();
        $this->assertNotEmpty($checkIfWasUpdated);
    }

    // -------------------------
    // FUNCTION TEST DELETE
    // -------------------------

    public function test_delete() {
        $this->getConnection()->deletePost(6);
        $checkIfWasDelete = $this->getConnection()->select_SQLResult(null, "un Nouveau Titre", 3, "2023-10-06", "2023-10-06")->getContent();
        $this->assertEmpty($checkIfWasDelete);
    }
}
