<?php

include '../GFramework/database/Database.php';
include '../GFramework/database/DbUsers.php';
require '../GFramework/autoloader.php';

use PHPUnit\Framework\TestCase;
class DbUsersTest extends TestCase { // Completed

    private DbUsers | null $dbUsers = null;
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
    // FUNCTION TEST SELECT WITH FILTER
    // -------------------------

    public function test_no_filter() {
        $result = $this->getConnection()->convertSQLResultToAssocArray($this->getConnection()->select_SQLResult())->getContent();
        $this->assertEquals(5, sizeof($result));
    }

    public function test_one_filter() {
        $result = $this->getConnection()->convertSQLResultToAssocArray($this->getConnection()->select_SQLResult("be"))->getContent();
        $this->assertEquals(2, sizeof($result));
    }

    public function test_one_filter_2() {
        $result = $this->getConnection()->convertSQLResultToAssocArray($this->getConnection()->select_SQLResult(null, 0))->getContent();
        $this->assertEquals(4, sizeof($result));
    }

    public function  test_some_filter() {
        $result = $this->getConnection()->convertSQLResultToAssocArray($this->getConnection()->select_SQLResult("mar", null, 0))->getContent();
        $this->assertEquals(1, sizeof($result));
    }

    public function test_some_filter_2() {
        $result = $this->getConnection()->convertSQLResultToAssocArray($this->getConnection()->select_SQLResult(null, 1, 1))->getContent();
        $this->assertEquals(1, sizeof($result));
    }

    // -------------------------
    // FUNCTION TEST SELECTION UNIQUE ATTRIBUT
    // -------------------------

    /* by ID */
    public function test_select_by_id_and_id_exist() {
        $result = $this->getConnection()->selectById("1")->getContent()["USERNAME"];
        $this->assertEquals('admin', $result);
    }
    public function test_select_by_id_and_id_dont_exist() {
        $result = $this->getConnection()->selectById("6")->getContent();
        $this->assertEquals(null, $result);
    }

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
    }

    /* function test remove */

    public function test_delete_valid_user() {
        $this->getConnection()->deleteUserByID(6);
        $this->assertEmpty($this->getConnection()->selectByUsername("nameV2")->getContent());
    }

}