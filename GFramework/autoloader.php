<?php
require_once("database/db.php");
require_once("database/dbUsers.php");
require_once("utilities/GReturn.php");

$db = new db('mysql-echo.alwaysdata.net','echo_mathieu','130304leroux','echo_test_bd');
$dbConn = $db->getConnection()->getContent();
//var_dump($dbConn);
?>