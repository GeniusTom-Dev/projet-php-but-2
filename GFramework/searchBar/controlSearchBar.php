<?php

function getTopicsSearchParameters(): array{
    return ['searchId', 'searchText'];
}
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

function getUsersSearchParameters(): array{
    return ['searchId', 'searchText', 'searchIsAdmin', 'searchIsActivate'];
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

function getPostsSearchParameters(): array{
    return ['searchId', 'searchText', 'searchUserId', 'searchDateMin', 'searchDateMax'];
}
function getPostsResults($dbPosts)
{
    if (empty($_GET['searchId']) === false) {
        $results = [$dbPosts->selectById($_GET['searchId'])->getContent()];
    } else {
        $contentOrTitleLike = (empty($_GET['searchText']) === false) ? $_GET['searchText'] : null;
        $user_id = (empty($_GET['searchUserId']) === false) ? $_GET['searchUserId'] : null;
        $dateMin = (empty($_GET['searchDateMin']) === false) ? $_GET['searchDateMin'] : null;
        $dateMax = (empty($_GET['searchDateMax']) === false) ? $_GET['searchDateMax'] : null;
        $results = $dbPosts->select_SQLResult($contentOrTitleLike, $user_id, $dateMin, $dateMax)->getContent();
    }
    return $results;
}

function getCommentsSearchParameters(): array{
    return ['searchId', 'searchPostId', 'searchUserId', 'searchText', 'searchDateMin', 'searchDateMax'];
}
function getCommentsResults($dbComments)
{
    if (empty($_GET['searchId']) === false) {
        $results = [$dbComments->selectById($_GET['searchId'])->getContent()];
    } else {
        $post_id = (empty($_GET['searchPostId']) === false) ? $_GET['searchPostId'] : null;
        $user_id = (empty($_GET['searchUserId']) === false) ? $_GET['searchUserId'] : null;
        $contentLike = (empty($_GET['searchText']) === false) ? $_GET['searchText'] : null;
        $dateMin = (empty($_GET['searchDateMin']) === false) ? $_GET['searchDateMin'] : null;
        $dateMax = (empty($_GET['searchDateMax']) === false) ? $_GET['searchDateMax'] : null;
        $results = $dbComments->select_SQLResult($post_id, $user_id, $contentLike, $dateMin, $dateMax)->getContent();
    }
    return $results;
}