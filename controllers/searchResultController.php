<?php

namespace controllers;

use GFramework\utilities\controlGeneratePosts;
use GFramework\utilities\controlGenerateComments;
use GFramework\utilities\controlTopic;
use GFramework\utilities\controlUser;

class searchResultController
{
    function whatToDisplay($dbComments, $dbFavorites, $dbFollows, $dbLikes, $dbPosts, $dbTopics, $dbUsers, ?int $limit = null, ?int $page = null, ?string $sort = null): string
    {
        $results = [];
        if (empty($_GET["selectDb"]) === false) {
            if ($_GET["selectDb"] == "Topics") {
                return $this->displayTopic($this->getTopicsResults($dbTopics, $limit, $page, $sort), $dbTopics);
            } else if ($_GET["selectDb"] == "Users") {
                return $this->displayUsers($this->getUsersResults($dbUsers, $limit, $page, $sort), $dbFollows, $dbUsers);
            } else if ($_GET["selectDb"] == "Posts") {
                return $this->displayPosts($this->getPostsResults($dbPosts, $dbTopics, $limit, $page, $sort), $dbComments, $dbFavorites, $dbFollows, $dbLikes, $dbPosts, $dbTopics, $dbUsers);
            } else if ($_GET["selectDb"] == "Comments") {
                return $this->displayComments($this->getCommentsResults($dbComments, $limit, $page, $sort), $dbComments, $dbPosts, $dbUsers, $dbFollows);
            }
        } else {
            if (!isset($_GET['selectDb'])) {
                $_GET['selectDb'] = "Topics";
                return $this->displayTopic($this->getTopicsResults($dbTopics, $limit, $page, $sort), $dbTopics);
            }
        }
        return "";
    }

    function displayComments($searchResult, $dbComments, $dbPosts, $dbUsers, $dbFollows): string
    {

        $controller = new \controllers\controlGenerateComments($dbComments, $dbPosts, $dbUsers, $dbFollows);
        $controller->checkAllShowActions();
        $htmlCode = "";
        foreach ($searchResult as $comment) {
            $htmlCode .= '<tr>' . $controller->getCommentHTML($comment["COMMENT_ID"]) . '</tr>';
        }
        return $htmlCode;
    }

    function displayPosts($searchResult, $dbComments, $dbFavorites, $dbFollows, $dbLikes, $dbPosts, $dbTopics, $dbUsers): string
    {
        $controller = new controlGeneratePosts($dbComments, $dbFavorites, $dbFollows, $dbLikes, $dbPosts, $dbTopics, $dbUsers);
        $controller->checkAllShowActions();
        $htmlCode = "";
        foreach ($searchResult as $post) {
            $htmlCode .= '<tr>' . $controller->getPostHTML($post["POST_ID"]) . '</tr>';
        }
        return $htmlCode;
    }

    function displayUsers($searchResult, $dbFollows, $dbUsers): string
    {
        $controller = new \controllers\controlUser($dbFollows, $dbUsers);
        $controller->checkSubscribe();
        $htmlCode = "";
        foreach ($searchResult as $user) {
            $htmlCode .= '<tr>' . $controller->getUserProfileSimple($user["USER_ID"]) . '</tr>';
        }
        return $htmlCode;
    }

    function displayTopic($searchResult, $dbTopics): string
    {
        $controller = new \controllers\controlTopic($dbTopics);
        $htmlCode = "";
        foreach ($searchResult as $topic) {
            $htmlCode .= '<tr>' . $controller->getTopic($topic['TOPIC_ID']) . '</tr>';
        }
        return $htmlCode;
    }

    /**
     * Retrieve topics based on search criteria from the search bar form.
     *
     * @param $dbTopics
     * @return array An array of topic results matching the search criteria.
     */
    function getTopicsResults($dbTopics, ?int $limit = null, ?int $page = null, ?string $sort = null): array
    {
        if (empty($_GET["searchId"]) === false) {
            $results = [$dbTopics->selectById($_GET["searchId"])->getContent()];
        } else {
            $nameOrDescriptionLike = (empty($_GET["searchText"]) === false) ? $_GET['searchText'] : null;
            $results = $dbTopics->select_SQLResult($nameOrDescriptionLike, $limit, $page, $sort)->getContent();
        }
        return $results;
    }

    /**
     * Retrieve users based on search criteria from the search bar form.
     *
     * @param $dbUsers
     * @return array An array of user results matching the search criteria.
     */
    function getUsersResults($dbUsers, ?int $limit = null, ?int $page = null, ?string $sort = null): array
    {
        if (empty($_GET["searchId"]) === false) {
            $results = [$dbUsers->selectById($_GET['searchId'])->getContent()];
        } else {
            $usernameLike = (empty($_GET['searchText']) === false) ? $_GET['searchText'] : null;
            $isAdmin = (empty($_GET['searchIsAdmin']) === false) ? $_GET['searchIsAdmin'] : null;
            $isActivate = (empty($_GET['searchIsActivate']) === false) ? $_GET['searchIsActivate'] : null;
            $results = $dbUsers->select_SQLResult($usernameLike, $isAdmin, $isActivate, $limit, $page, $sort)->getContent();
        }
        return $results;
    }

    /**
     * Retrieve posts based on search criteria from the search bar form.
     *
     * @param $dbPosts
     * @param $dbTopics
     * @return array An array of post results matching the search criteria.
     */
    function getPostsResults($dbPosts, $dbTopics, ?int $limit = null, ?int $page = null, ?string $sort = null): array
    {
        if (empty($_GET['searchId']) === false) {
            $results = [$dbPosts->selectById($_GET['searchId'])->getContent()];
        } else {
            $topicId = (empty($_GET['searchInputTopic']) === false) ? $dbTopics->selectByName($_GET['searchInputTopic'])->getContent()["TOPIC_ID"] : null;
            $contentOrTitleLike = (empty($_GET['searchText']) === false) ? $_GET['searchText'] : null;
            $user = (empty($_GET['searchUserId']) === false) ? intval($_GET['searchUserId']) : null;
            if (is_null($user)) {
                $user = (empty($_GET['searchUser']) === false) ? $_GET['searchUser'] : null;
            }
            $dateMin = (empty($_GET['searchDateMin']) === false) ? $_GET['searchDateMin'] : null;
            $dateMax = (empty($_GET['searchDateMax']) === false) ? $_GET['searchDateMax'] : null;
            $results = $dbPosts->select_SQLResult($topicId, $contentOrTitleLike, $user, $dateMin, $dateMax, $limit, $page, $sort)->getContent();
        }
        return $results;
    }

    /**
     * Retrieve comments based on search criteria from the search bar form.
     *
     * @param $dbComments
     * @return array An array of comment results matching the search criteria.
     */
    function getCommentsResults($dbComments, ?int $limit = null, ?int $page = null, ?string $sort = null): array
    {
        if (empty($_GET['searchId']) === false) {
            $results = [$dbComments->selectById($_GET['searchId'])->getContent()];
        } else {
            $post_id = (empty($_GET['searchPostId']) === false) ? $_GET['searchPostId'] : null;
            $user = (empty($_GET['searchUserId']) === false) ? intval($_GET['searchUserId']) : null;
            if (is_null($user)) {
                $user = (empty($_GET['searchUser']) === false) ? $_GET['searchUser'] : null;
            }
            $contentLike = (empty($_GET['searchText']) === false) ? $_GET['searchText'] : null;
            $dateMin = (empty($_GET['searchDateMin']) === false) ? $_GET['searchDateMin'] : null;
            $dateMax = (empty($_GET['searchDateMax']) === false) ? $_GET['searchDateMax'] : null;
            $results = $dbComments->select_SQLResult($post_id, $user, $contentLike, $dateMin, $dateMax, $limit, $page, $sort)->getContent();
        }
        return $results;
    }

    function getTotal($dbComments, $dbPosts, $dbTopics, $dbUsers): int
    {
        if (isset($_GET["selectDb"])) {
            if ($_GET["selectDb"] == "Topics") {
                return sizeof($this->getTopicsResults($dbTopics));
            } else if ($_GET["selectDb"] == "Users") {
                return sizeof($this->getUsersResults($dbUsers));
            } else if ($_GET["selectDb"] == "Posts") {
                return sizeof($this->getPostsResults($dbPosts, $dbTopics));
            } else if ($_GET["selectDb"] == "Comments") {
                return sizeof($this->getCommentsResults($dbComments));
            }
        } else {
            return sizeof($this->getTopicsResults($dbTopics));
        }
        return 0;
    }
}