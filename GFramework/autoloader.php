<?php
require_once("database/Database.php");
require_once("database/DbUsers.php");
require_once("utilities/GReturn.php");

$db = new Database('mysql-echo.alwaysdata.net','echo_mathieu','130304leroux','echo_test_bd');
$dbConn = $db->getConnection()->getContent();
//var_dump($db->getConnection());