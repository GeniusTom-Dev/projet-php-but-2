<?php
// Pour init les BD et les id d'utilisateur -> ne sera pas dans la version finale
require_once("GFramework/database/Database.php");
require_once("GFramework/database/DbUsers.php");
require_once("GFramework/database/DbFollows.php");
require_once("GFramework/utilities/GReturn.php");

$db = new Database('mysql-echo.alwaysdata.net', 'echo_mathieu', '130304leroux', 'echo_bd');
$dbConn = $db->getConnection()->getContent();

$dbUsers = new DbUsers($dbConn);
$dbFollows = new DbFollows($dbConn);
