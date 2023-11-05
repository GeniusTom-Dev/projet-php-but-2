<?php
require_once __DIR__ . '/../autoloader.php';
require_once __DIR__ . '/../../controllers/controlTopic.php';
require_once __DIR__ . '/../../controllers/controlUser.php';
require_once __DIR__ . '/../../controllers/controlGeneratePosts.php';


function whatToDisplay($dbComments, $dbFavorites, $dbFollows, $dbLikes, $dbPosts, $dbTopics, $dbUsers, ?int $limit = null, ?int $page = null, ?string $sort = null): void
{
    $results = [];
    if (empty($_GET["selectDb"]) === false) {
        if ($_GET["selectDb"] == "Topics") {
            displayTopic(getTopicsResults($dbTopics, $limit, $page, $sort), $dbTopics);
        } else if ($_GET["selectDb"] == "Users") {
            displayUsers(getUsersResults($dbUsers, $limit, $page, $sort), $dbFollows, $dbUsers);
        } else if ($_GET["selectDb"] == "Posts") {
            displayPosts(getPostsResults($dbPosts, $dbTopics, $limit, $page, $sort), $dbComments, $dbFavorites, $dbFollows, $dbLikes, $dbPosts, $dbTopics, $dbUsers);
        } else if ($_GET["selectDb"] == "Comments") {
            $results = getCommentsResults($dbComments, $limit, $page, $sort);
        }
    } else {
        if (!isset($_GET['selectDb'])) {
            $_GET['selectDb'] = "Topics";
            displayTopic(getTopicsResults($dbTopics, $limit, $page, $sort), $dbTopics);
        }
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

function displayTopic($searchResult, $dbTopics): void
{
    $controller = new \controllers\controlTopic($dbTopics);
    $htmlCode = "";
    foreach ($searchResult as $topic) {
        $htmlCode .= '<tr>' . $controller->getTopic($topic['TOPIC_ID']) . '</tr>';
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