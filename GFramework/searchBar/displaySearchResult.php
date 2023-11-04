<?php
require_once __DIR__ .'/../autoloader.php';


function whatToDisplay() {

    $db = new Database('mysql-echo.alwaysdata.net', 'echo_mathieu', '130304leroux', 'echo_bd');
    $dbConn = $db->getConnection()->getContent();

    $dbComments = new DbComments($dbConn);
    $dbFavorites = new DbFavorites($dbConn);
    $dbFollows = new DbFollows($dbConn);
    $dbLikes = new DbLikes($dbConn);
    $dbPosts = new DbPosts($dbConn);
    $dbTopics = new DbTopics($dbConn);
    $dbUsers = new DbUsers($dbConn);
    /*if (empty($_GET["selectDb"]) === false) {
        if ($_GET["selectDb"] == "Topics") $results = getTopicsResults($dbTopics);
        else if ($_GET["selectDb"] == "Users") $results = getUsersResults($dbUsers);
        else if ($_GET["selectDb"] == "Posts") $results = getPostsResults($dbPosts, $dbTopics);
        else if ($_GET["selectDb"] == "Comments") $results = getCommentsResults($dbComments);
    } else {
        if (!isset($_GET['selectDb'])) {
            $_GET['selectDb'] = "Topics";
        }
        $results = getTopicsResults($dbTopics);
    }*/
    displayPosts(getPostsResults($dbPosts, $dbTopics), $dbConn);
}

function displayPosts($searchResult, $dbConn) : void {
    $controller = new controlGeneratePosts($dbConn);
    $htmlCode = "";
    foreach ($searchResult as $post) {
        $htmlCode .= '<tr>' . $controller->getPostHTML($post["POST_ID"]) . '</tr>';
    }
    echo $htmlCode;
}
