<?php
function getTopicsResults($dbTopics)
{
    $results = [];
    if (empty($_GET["searchId"]) === false && $_GET['searchId'] === false) {
        $results = [$dbTopics->selectById($_GET["searchId"])->getContent()];
    } else if (empty($_GET["searchText"]) === false) {
        $nameOrDescriptionLike = $_GET['searchText'];
        $results = $dbTopics->select_SQLResult($nameOrDescriptionLike)->getContent();
    } else {
        $results = $dbTopics->select_SQLResult()->getContent();
    }

    return $results;
}

function getUsersResults($dbUsers)
{
    $results = [];
    if ($_GET["searchId"] === false) {
        $results = [$dbUsers->selectById($_GET['searchId'])->getContent()];
    } else {
        $usernameLike = $_GET['searchText'];
        $isAdmin = $_GET['searchIsAdmin'];
        $isActivate = $_GET['searchIsActivate'];
        $results = $dbUsers->select_SQLResult($usernameLike, $isAdmin, $isActivate)->getContent();
    }
    return $results;
}

function getPostsResults($dbPosts)
{
    $results = [];
    $results = $dbPosts->select_SQLResult(null, null, null, null)->getContent();
    return $results;
}

function getCommentsResults($dbComments)
{
    $results = [];
    $results = $dbComments->select_SQLResult(null, null, null, null, null)->getContent();
    return $results;
}

?>