<?php

namespace Tests;
include '../GFramework/database/Database.php';
include '../GFramework/database/DbLikes.php';
require '../GFramework/autoloader.php';

use Database;
use Dblikes;
use PHPUnit\Framework\TestCase;

class DbLikesTest extends TestCase { // Completed
    private DbLikes|null $dbLikes = null;

    final public function getConnection(): DbLikes
    {
        if ($this->dbLikes == null) {
            $db = new Database('mysql-echo.alwaysdata.net', 'echo_mathieu', '130304leroux', 'echo_bd_test');
            $dbConn = $db->getConnection()->getContent();
            $this->dbLikes = new DbLikes($dbConn);
        }
        return $this->dbLikes;
    }

    public function test_nb_likes_per_post() {
        $this->assertEquals(3, $this->getConnection()->countPostLike(1));
        $this->assertEquals(0, $this->getConnection()->countPostLike(3));
    }

    public function test_add_like() {
        $this->assertEquals(2, $this->getConnection()->countPostLike(2));
        $this->getConnection()->addLike(4,2);
        $this->assertEquals(3, $this->getConnection()->countPostLike(2));
    }

    public function test_remove_like() {
        $this->assertEquals(3, $this->getConnection()->countPostLike(2));
        $this->getConnection()->removeLike(4,2);
        $this->assertEquals(2, $this->getConnection()->countPostLike(2));
    }
}
