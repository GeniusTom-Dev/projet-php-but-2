<?php
require_once("database/Database.php");
require_once("database/dbTopics.php");
require_once("database/DbUsers.php");
require_once("database/dbPosts.php");
require_once("database/dbComments.php");
require_once("utilities/GReturn.php");
require_once("utilities/CannotDoException.php");

$db = new Database('mysql-echo.alwaysdata.net','echo_mathieu','130304leroux','echo_bd_test');
$dbConn = $db->getConnection()->getContent();
?>