<?php
namespace Tests;
include '../GFramework/database/Database.php';
include '../GFramework/database/DbFollows.php';
require '../GFramework/autoloader.php';

use Database;
use DbFollows;
use PHPUnit\Framework\TestCase;

class DbFollowsTest extends TestCase { // Completed

    private DbFollows|null $dbFollows = null;

    final public function getConnection(): DbFollows
    {
        if ($this->dbFollows == null) {
            $db = new Database('mysql-echo.alwaysdata.net', 'echo_mathieu', '130304leroux', 'echo_bd_test');
            $dbConn = $db->getConnection()->getContent();
            $this->dbFollows = new DbFollows($dbConn);
        }
        return $this->dbFollows;
    }

    public function test_does_user_follow_another_user() {
        $this->assertTrue($this->getConnection()->doesUserFollowAnotherUser(1,2));
        $this->assertFalse($this->getConnection()->doesUserFollowAnotherUser(3,2));
        $this->assertFalse($this->getConnection()->doesUserFollowAnotherUser(1,1));
    }

    public function test_get_follower_count() {
        $this->assertEquals(1, $this->getConnection()->countFollower(1));
        $this->assertEquals(2, $this->getConnection()->countFollower(3));
        $this->assertEquals(0, $this->getConnection()->countFollower(4));
    }

    public function test_get_followed_count() {
        $this->assertEquals(3, $this->getConnection()->countFollowed(1));
        $this->assertEquals(1, $this->getConnection()->countFollowed(3));
        $this->assertEquals(0, $this->getConnection()->countFollowed(4));
    }

    public function test_add_follow() {
        $this->assertEquals(1, $this->getConnection()->countFollower(1));
        $this->assertEquals(1, $this->getConnection()->countFollowed(3));
        $this->getConnection()->addFollow(3,1);
        $this->assertEquals(2, $this->getConnection()->countFollower(1));
        $this->assertEquals(2, $this->getConnection()->countFollowed(3));
    }

    public function test_remove_follow() {
        $this->assertEquals(2, $this->getConnection()->countFollower(1));
        $this->assertEquals(2, $this->getConnection()->countFollowed(3));
        $this->getConnection()->removeFollow(3,1);
        $this->assertEquals(1, $this->getConnection()->countFollower(1));
        $this->assertEquals(1, $this->getConnection()->countFollowed(3));
    }
}
