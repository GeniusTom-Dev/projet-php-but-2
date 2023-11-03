<?php

function getTopicsResults($dbTopics)
{
    if (empty($_GET["searchId"]) === false) {
        $results = [$dbTopics->selectById($_GET["searchId"])->getContent()];
    } else {
        $nameOrDescriptionLike = (empty($_GET["searchText"]) === false) ? $_GET['searchText'] : null;
        $results = $dbTopics->select_SQLResult($nameOrDescriptionLike)->getContent();
    }
    return $results;
}

function getUsersResults($dbUsers)
{
    if (empty($_GET["searchId"]) === false) {
        $results = [$dbUsers->selectById($_GET['searchId'])->getContent()];
    } else {
        $usernameLike = (empty($_GET['searchText']) === false) ? $_GET['searchText'] : null;
        $isAdmin = (empty($_GET['searchIsAdmin']) === false) ? $_GET['searchIsAdmin'] : null;
        $isActivate = (empty($_GET['searchIsActivate']) === false) ? $_GET['searchIsActivate'] : null;
        $results = $dbUsers->select_SQLResult($usernameLike, $isAdmin, $isActivate)->getContent();
    }
    return $results;
}

function getPostsResults($dbPosts, $dbTopics, $dbUsers)
{
    if (empty($_GET['searchId']) === false) {
        $results = [$dbPosts->selectById($_GET['searchId'])->getContent()];
    } else {
        $topicId = (empty($_GET['searchInputTopic']) === false) ? $dbTopics->selectByName($_GET['searchInputTopic'])->getContent()["TOPIC_ID"] : null;
        $contentOrTitleLike = (empty($_GET['searchText']) === false) ? $_GET['searchText'] : null;
        $user = (empty($_GET['searchUserId']) === false) ? $_GET['searchUserId'] : null;
        if (is_null($user)) {
            $user = (empty($_GET['searchUser']) === false) ? $_GET['searchUser'] : null;
        }
        $dateMin = (empty($_GET['searchDateMin']) === false) ? $_GET['searchDateMin'] : null;
        $dateMax = (empty($_GET['searchDateMax']) === false) ? $_GET['searchDateMax'] : null;
        $results = $dbPosts->select_SQLResult($topicId, $contentOrTitleLike, $user, $dateMin, $dateMax)->getContent();
    }
    return $results;
}

function getCommentsResults($dbComments, $dbUsers)
{
    if (empty($_GET['searchId']) === false) {
        $results = [$dbComments->selectById($_GET['searchId'])->getContent()];
    } else {
        $post_id = (empty($_GET['searchPostId']) === false) ? $_GET['searchPostId'] : null;
        $user = (empty($_GET['searchUserId']) === false) ? $_GET['searchUserId'] : null;
        if (is_null($user)) {
            $user = (empty($_GET['searchUser']) === false) ? $_GET['searchUser'] : null;
        }
        $contentLike = (empty($_GET['searchText']) === false) ? $_GET['searchText'] : null;
        $dateMin = (empty($_GET['searchDateMin']) === false) ? $_GET['searchDateMin'] : null;
        $dateMax = (empty($_GET['searchDateMax']) === false) ? $_GET['searchDateMax'] : null;
        $results = $dbComments->select_SQLResult($post_id, $user, $contentLike, $dateMin, $dateMax)->getContent();
    }
    return $results;
}
