<?php

include '../GFramework/database/Database.php';
include '../GFramework/database/DbUsers.php';
require '../GFramework/autoloader.php';

use PHPUnit\Framework\TestCase;
class dbUsersTest extends TestCase {

    private $dbUsers = null;
    final public function getConnection() {
        if ($this->dbUsers == null) {
            $db = new Database('mysql-echo.alwaysdata.net','echo_mathieu','130304leroux','echo_test_bd');
            $dbConn = $db->getConnection()->getContent();
            $this->dbUsers = new DbUsers($dbConn);
        }
        return $this->dbUsers;
    }

    // -------------------------
    // FUNCTION TEST GET
    // -------------------------

    public function test_get_all_users() {
        $result = $this->getConnection()->getUsers(["USER_ID"])->getContent();
        $expected = [['USER_ID'=>'0'],['USER_ID'=>'1'],['USER_ID'=>'2'],['USER_ID'=>'3'],['USER_ID'=>'4']];
        $this->assertEquals(array_count_values($expected), array_count_values($result));
    }

    public function test_get_all_users_2() {
        $result = $this->getConnection()->getUsers(["USERNAME", "USER_BIO"])->getContent();
        $expected = [['USERNAME'=>'admin', 'USER_BIO'=>null],['USERNAME'=>'benoit', 'USER_BIO'=>null],['USERNAME'=>'bebert', 'USER_BIO'=>'Bio de bebert'],['USERNAME'=>'martin', 'USER_BIO'=>'Bio de martin'],['USERNAME'=>'martine', 'USER_BIO'=>'Bio de martine']];
        $this->assertEquals(array_count_values($expected), array_count_values($result));
    }

    // -------------------------
    // FUNCTION TEST SELECTION
    // -------------------------

    /* by id */
    public function test_select_by_id_and_id_exist() {
        $result = $this->getConnection()->select_by_id(1)->getContent()["USERNAME"];
        $this->assertEquals('benoit', $result);
    }
    public function test_select_by_id_and_id_dont_exist() {
        $result = $this->getConnection()->select_by_id(5)->getContent()["USERNAME"];
        $this->assertEquals(null, $result);
    }

    /* by username */
    public function test_select_by_username_and_username_exist() {
        $result = $this->getConnection()->select_by_username("admin")->getContent()["USER_ID"];
        $this->assertEquals('0', $result);
    }
    public function test_select_by_username_and_username_dont_exist() {
        $result = $this->getConnection()->select_by_username("dnvrvrv")->getContent()["USER_ID"];
        $this->assertEquals(null, $result);
    }

    /* by email */
    public function test_select_by_email_and_email_exist() {
        $result = $this->getConnection()->select_by_email("beber@gmail.com")->getContent()["USER_ID"];
        $this->assertEquals('2', $result);
    }
    public function test_select_by_email_and_email_dont_exist()
    {
        $result = $this->getConnection()->select_by_email("dnvrvrv")->getContent()["USER_ID"];
        $this->assertEquals(null, $result);
    }

    // -------------------------
    // FUNCTION TEST UPDATE - ADD - REMOVE
    // -------------------------

    public function test_add_valid_user() {

    }
    public function test_update_user_username_and_username_valid() {
        $result = $this->getConnection()->updateUsername("bebert", "MATHIEU");
        $this->assertTrue($result);
    }

    // function test add

    // function test remove
}