<?php
require_once __DIR__ .'/../autoloader.php';


function whatToDisplay($dbComments, $dbFavorites, $dbFollows, $dbLikes, $dbPosts,$dbTopics, $dbUsers) {

    /*$db = new Database('mysql-echo.alwaysdata.net', 'echo_mathieu', '130304leroux', 'echo_bd');
    $dbConn = $db->getConnection()->getContent();

    $dbComments = new DbComments($dbConn);
    $dbFavorites = new DbFavorites($dbConn);
    $dbFollows = new DbFollows($dbConn);
    $dbLikes = new DbLikes($dbConn);
    $dbPosts = new DbPosts($dbConn);
    $dbTopics = new DbTopics($dbConn);
    $dbUsers = new DbUsers($dbConn);*/

    $results = [];
    if (empty($_GET["selectDb"]) === false) {
        if ($_GET["selectDb"] == "Topics") $results = getTopicsResults($dbTopics);
        else if ($_GET["selectDb"] == "Users") $results = getUsersResults($dbUsers);
        else if ($_GET["selectDb"] == "Posts") displayPosts(getPostsResults($dbPosts, $dbTopics), $dbComments, $dbFavorites, $dbFollows, $dbLikes, $dbPosts,$dbTopics, $dbUsers);
        else if ($_GET["selectDb"] == "Comments") $results = getCommentsResults($dbComments);
    } else {
        if (!isset($_GET['selectDb'])) {
            $_GET['selectDb'] = "Topics";
        }
        $results = getTopicsResults($dbTopics);
    }
    echo "<p>ok mon reuf</p>";
}

function displayPosts($searchResult, $dbComments, $dbFavorites, $dbFollows, $dbLikes, $dbPosts,$dbTopics, $dbUsers) : void {
    $controller = new controlGeneratePosts($dbComments, $dbFavorites, $dbFollows, $dbLikes, $dbPosts,$dbTopics, $dbUsers);
    $controller->checkAllShowActions();
    $htmlCode = "";
    foreach ($searchResult as $post) {
        $htmlCode .= '<tr>' . $controller->getPostHTML($post["POST_ID"]) . '</tr>';
    }
    echo $htmlCode;
}
