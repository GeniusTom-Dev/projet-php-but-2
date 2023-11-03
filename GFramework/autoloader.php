<?php
require_once("database/Database.php");
require_once("database/DbComments.php");
require_once("database/DbFavorites.php");
require_once("database/DbFollows.php");
require_once("database/DbLikes.php");
require_once("database/DbPosts.php");
require_once("database/DbTopics.php");
require_once("database/DbUsers.php");
require_once("utilities/GReturn.php");
require_once("utilities/CannotDoException.php");
require_once("searchBar/SearchParameters.php");
require_once("../controllers/controlGeneratePosts.php");
require_once("../controllers/controlGenerateFullPosts.php");
require_once("../controllers/controlCreatePosts.php");

$db = new Database('mysql-echo.alwaysdata.net', 'echo_mathieu', '130304leroux', 'echo_bd');
$dbConn = $db->getConnection()->getContent();

$dbComments = new DbComments($dbConn);
$dbFavorites = new DbFavorites($dbConn);
$dbFollows = new DbFollows($dbConn);
$dbLikes = new DbLikes($dbConn);
$dbPosts = new DbPosts($dbConn);
$dbTopics = new DbTopics($dbConn);
$dbUsers = new DbUsers($dbConn);
?>