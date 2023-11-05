<?php
require_once __DIR__ . '/../autoloader.php';


function whatToDisplay($dbComments, $dbFavorites, $dbFollows, $dbLikes, $dbPosts, $dbTopics, $dbUsers, $limit, ?int $page = null, ?string $sort = null)
{
    $results = [];
    if (empty($_GET["selectDb"]) === false) {
        if ($_GET["selectDb"] == "Topics") {
            $results = getTopicsResults($dbTopics);
        } else if ($_GET["selectDb"] == "Users") {
            displayUsers(getUsersResults($dbUsers), $dbFollows, $dbUsers);
        } else if ($_GET["selectDb"] == "Posts") {
            displayPosts(getPostsResults($dbPosts, $dbTopics, $limit, $page, $sort), $dbComments, $dbFavorites, $dbFollows, $dbLikes, $dbPosts, $dbTopics, $dbUsers);
        } else if ($_GET["selectDb"] == "Comments") {
            $results = getCommentsResults($dbComments);
        }
    } else {
        if (!isset($_GET['selectDb'])) {
            $_GET['selectDb'] = "Topics";
        }
        $results = getTopicsResults($dbTopics);
    }
}

function displayPosts($searchResult, $dbComments, $dbFavorites, $dbFollows, $dbLikes, $dbPosts, $dbTopics, $dbUsers): void
{
    $controller = new controlGeneratePosts($dbComments, $dbFavorites, $dbFollows, $dbLikes, $dbPosts, $dbTopics, $dbUsers);
    $controller->checkAllShowActions();
    $htmlCode = "";
    foreach ($searchResult as $post) {
        $htmlCode .= '<tr>' . $controller->getPostHTML($post["POST_ID"]) . '</tr>';
    }
    echo $htmlCode;
}

function displayUsers($searchResult, $dbFollows, $dbUsers): void
{
    $controller = new \controllers\controlUser($dbFollows, $dbUsers);
    $controller->checkSubscribe();
    $htmlCode = "";
    foreach ($searchResult as $user) {
        $htmlCode .= '<tr>' . $controller->getUserProfileSimple($user["USER_ID"]) . '</tr>';
    }
    echo $htmlCode;
}

function getTotal($dbComments, $dbPosts, $dbTopics, $dbUsers): int
{
    if (isset($_GET["selectDb"])) {
        if ($_GET["selectDb"] == "Topics") {
            return sizeof(getTopicsResults($dbTopics));
        } else if ($_GET["selectDb"] == "Users") {
            return sizeof(getUsersResults($dbUsers));
        } else if ($_GET["selectDb"] == "Posts") {
            return sizeof(getPostsResults($dbPosts, $dbTopics));
        } else if ($_GET["selectDb"] == "Comments") {
            return sizeof(getCommentsResults($dbComments));
        }
    } else {
        return sizeof(getTopicsResults($dbTopics));
    }
    return 0;
}