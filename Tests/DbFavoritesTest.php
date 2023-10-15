<?php
namespace Tests;
include '../GFramework/database/Database.php';
include '../GFramework/database/DbFavorites.php';
require '../GFramework/autoloader.php';

use Database;
use DbFavorites;
use PHPUnit\Framework\TestCase;

class DbFavoritesTest extends TestCase { // Completed
    private DbFavorites|null $dbFavorites = null;

    final public function getConnection(): DbFavorites
    {
        if ($this->dbFavorites == null) {
            $db = new Database('mysql-echo.alwaysdata.net', 'echo_mathieu', '130304leroux', 'echo_bd_test');
            $dbConn = $db->getConnection()->getContent();
            $this->dbFavorites = new DbFavorites($dbConn);
        }
        return $this->dbFavorites;
    }

    public function test_does_user_has_favorites_a_post() {
        $this->assertTrue($this->getConnection()->doesUserHaveFavoritedThisPost(1,2));
        $this->assertFalse($this->getConnection()->doesUserHaveFavoritedThisPost(2,2));
        $this->assertFalse($this->getConnection()->doesUserHaveFavoritedThisPost(4,5));
    }

    public function test_add_favorites() {
        $this->assertFalse($this->getConnection()->doesUserHaveFavoritedThisPost(4,5));
        $this->getConnection()->addFavorite(4,5);
        $this->assertTrue($this->getConnection()->doesUserHaveFavoritedThisPost(4,5));
    }

    public function test_remove_follow() {
        $this->assertTrue($this->getConnection()->doesUserHaveFavoritedThisPost(4,5));
        $this->getConnection()->removeFavorite(4,5);
        $this->assertFalse($this->getConnection()->doesUserHaveFavoritedThisPost(4,5));
    }
}
