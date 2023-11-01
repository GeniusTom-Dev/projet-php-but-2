<?php

class SearchParameters
{

    public static function getTopicsSearchParameters(): array{
        return ['searchId', 'searchText'];
    }

    public static function getUsersSearchParameters(): array{
        return ['searchId', 'searchText', 'searchIsAdmin', 'searchIsActivate'];
    }

    public static function getPostsSearchParameters(): array{
        return ['searchId', 'searchText', 'searchUserId', 'searchDateMin', 'searchDateMax'];
    }

    public static function getCommentsSearchParameters(): array{
        return ['searchId', 'searchPostId', 'searchUserId', 'searchText', 'searchDateMin', 'searchDateMax'];
    }
}