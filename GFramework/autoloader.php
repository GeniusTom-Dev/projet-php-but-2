<?php
require_once("database/db.php");
require_once("database/dbTopics.php");
require_once("database/dbUsers.php");
require_once("database/dbPosts.php");
require_once("database/dbComments.php");
require_once("utilities/GReturn.php");
require_once("utilities/CannotDoException.php");

$db = new /*\GFramework\database\*/db('localhost','root','','php-proj');
$dbConn = $db->getConnection()->getContent();
//echo '<p>', var_dump($dbConn), '</p>';
?>