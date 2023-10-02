<?php

include '../GFramework/database/Database.php';
include '../GFramework/database/DbUsers.php';
require '../GFramework/autoloader.php';

use \PHPUnit\Framework\TestCase;
class DbUsersTest extends TestCase {

    private $dbUsers = null;
    final public function getConnection(): DbUsers
    {
        if ($this->dbUsers == null) {
            $db = new Database('mysql-echo.alwaysdata.net','echo_mathieu','130304leroux','echo_bd_test');
            $dbConn = $db->getConnection()->getContent();
            $this->dbUsers = new DbUsers($dbConn);
        }
        return $this->dbUsers;
    }

    // -------------------------
    // FUNCTION TEST GET
    // -------------------------

    public function test_get_all_users() {
        $result = $this->getConnection()->getUsers(["USERNAME"])->getContent();
        $expected = [['USERNAME'=>'admin'],['USERNAME'=>'bebert'],['USERNAME'=>'benoit'],['USERNAME'=>'martin'],['USERNAME'=>'martine']];
        $this->assertEquals(array_count_values($expected), array_count_values($result));
    }

    public function test_get_all_users_2() {
        $result = $this->getConnection()->getUsers(["USERNAME", "USER_BIO"])->getContent();
        $expected = [['USERNAME'=>'admin', 'USER_BIO'=>null],['USERNAME'=>'benoit', 'USER_BIO'=>null],['USERNAME'=>'bebert', 'USER_BIO'=>'Bio de bebert'],['USERNAME'=>'martin', 'USER_BIO'=>'Bio de martin'],['USERNAME'=>'martine', 'USER_BIO'=>'Bio de martine']];
        $this->assertEquals(array_count_values($expected), array_count_values($result));
    }

    // -------------------------
    // FUNCTION TEST SELECTION UNIQUE
    // -------------------------

    /* by username */
    public function test_select_by_username_and_username_exist() {
        $result = $this->getConnection()->selectByUsername("admin")->getContent()["USER_ID"];
        $this->assertEquals('1', $result);
    }
    public function test_select_by_username_and_username_dont_exist() {
        $result = $this->getConnection()->selectByUsername("dnvrvrv")->getContent()["USER_ID"];
        $this->assertEquals(null, $result);
    }

    /* by email */
    public function test_select_by_email_and_email_exist() {
        $result = $this->getConnection()->selectByEmail("bebert@gmail.com")->getContent()["USER_ID"];
        $this->assertEquals('2', $result);
    }
    public function test_select_by_email_and_email_dont_exist()
    {
        $result = $this->getConnection()->selectByEmail("dnvrvrv")->getContent()["USER_ID"];
        $this->assertEquals(null, $result);
    }

//    // -------------------------
//    // FUNCTION TEST SELECT WITH FILTER
//    // -------------------------
//
//    public function test_random() {
//        $result = mysqli_fetch_all($this->getConnection()->select_SQLResult(1)->getContent());
//        $result2 = mysqli_fetch_all($this->getConnection()->select_SQLResult(1)->getContent());
//        $this->assertEquals($result, $result2);
//    }

    // -------------------------
    // FUNCTION TEST UPDATE - ADD - REMOVE
    // -------------------------

    /* function test add */
    public function test_add_valid_user() {
        $this->assertTrue($this->getConnection()->addUser("nameV1", "emailV1.fr", "mdp"));
        $this->assertNotEmpty($this->getConnection()->selectByUsername("nameV1"));
    }

    public function test_add_invalid_user() {
        $this->assertFalse($this->getConnection()->addUser("admin", "", ""));
    }

    /* function test update */
    public function test_update_username_and_username_valid() {
        $this->assertTrue($this->getConnection()->updateUsername("nameV1", "nameV2"));
        $this->assertNotEmpty($this->getConnection()->selectByUsername("nameV2"));
    }

    public function test_update_username_and_username_invalid() {
        $this->assertFalse($this->getConnection()->updateUsername("abcd", "efgh"));
        $this->assertFalse($this->getConnection()->updateUsername("admin", "bebert"));
    }

    /* function test remove */

    public function test_delete_valid_user() {
        $this->getConnection()->deleteUserByID(6);
        $this->assertEmpty($this->getConnection()->selectByUsername("nameV2")->getContent());
    }

}