<?php
require_once("database/Database.php");
require_once("database/DbTopics.php");
require_once("database/DbUsers.php");
require_once("database/DbPosts.php");
require_once("database/DbComments.php");
require_once("utilities/GReturn.php");
require_once("utilities/CannotDoException.php");

$db = new Database('mysql-echo.alwaysdata.net','echo_mathieu','130304leroux','echo_bd');
$dbConn = $db->getConnection()->getContent();
?>