<?php

namespace Tests;
include '../GFramework/database/Database.php';
include '../GFramework/database/DbLikes.php';
require '../GFramework/autoloader.php';

use Database;
use Dblikes;
use PHPUnit\Framework\TestCase;

class DbLikesTest extends TestCase
{
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

    public function test_select_by_post_id()
    {
        $this->getConnection()->addLike(1, 1);
//        $this->assertEquals("Important", $result);
    }
}
