<?php
include '../GFramework/database/Database.php';
include '../GFramework/database/DbComments.php';
require '../GFramework/autoloader.php';

use PHPUnit\Framework\TestCase;

class DbCommentsTest extends TestCase
{ // Completed

    private DbComments|null $dbComments = null;

    final public function getConnection(): DbComments
    {
        if ($this->dbComments == null) {
            $db = new Database('mysql-echo.alwaysdata.net', 'echo_mathieu', '130304leroux', 'echo_bd_test');
            $dbConn = $db->getConnection()->getContent();
            $this->dbComments = new DbComments($dbConn);
        }
        return $this->dbComments;
    }

    // -------------------------
    // FUNCTION TEST SELECT
    // -------------------------

    // USED ONLY BY ADMINS IN THE ADMIN PANNEL

    public function test_select_by_only_post_id()
    {
        $result = $this->getConnection()->select_SQLResult(1)->getContent();
        $this->assertCount(2, $result);
    }

    public function test_select_by_only_user_id()
    {
        $result = $this->getConnection()->select_SQLResult(null, 1)->getContent();
        $this->assertCount(2, $result);
    }

    public function test_select_by_only_content()
    {
        $result = $this->getConnection()->select_SQLResult(null, null, "super")->getContent();
        $this->assertCount(3, $result);
    }

    public function test_select_by_like_date()
    {
        $result = $this->getConnection()->select_SQLResult(null, null, null, '2023-10-01', '2023-10-10')->getContent();
        $this->assertEquals(2, sizeOf($result));
    }

    public function test_select_many_filter()
    {
        $result = $this->getConnection()->select_SQLResult(1, 2, 'Pas', '2023-10-04', "2023-10-25")->getContent();
        $this->assertEquals(1, sizeof($result));
    }

    // -------------------------
    // FUNCTION TEST ADD
    // -------------------------

    public function test_add_comment()
    {
        $this->assertEmpty($this->getConnection()->select_SQLResult(1, 3, "Bjr", "2023-10-06", "2023-10-06")->getContent());
        $this->getConnection()->addComment(1, 3, "!!!", "2023-10-15");
        $this->assertNotEmpty($this->getConnection()->select_SQLResult(1, 3, "!!!", "2023-10-15", "2023-10-15")->getContent());
    }

    // -------------------------
    // FUNCTION TEST UPDATE
    // -------------------------

    public function test_update_comment()
    {
        $this->getConnection()->updateComments(5, "???");
        $this->assertNotEmpty($this->getConnection()->select_SQLResult(null, null, "???"));
    }

    // -------------------------
    // FUNCTION TEST DELETE
    // -------------------------

    public function test_delete_comment()
    {
        $this->getConnection()->deleteComment(5);
        $this->assertEmpty($this->getConnection()->select_SQLResult(null, null, "???")->getContent());
    }
}
