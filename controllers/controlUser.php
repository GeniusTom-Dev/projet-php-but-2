<?php

namespace controllers;
use controlGeneratePosts;
use DbFavorites;
use DbFollows;
use DbPosts;
use DbUsers;

class controlUser
{

    private DbUsers $dbUsers;
    private DbFollows $dbFollows;

    public function __construct($conn)
    {
        $this->dbFollows = new DbFollows($conn);
        $this->dbUsers = new DbUsers($conn);
    }

    public function getUserProfileSimple(int $userID): string
    {
        $userData = $this->dbUsers->selectById($userID)->getContent();
        ob_start(); ?>



        <?php $userHeader = ob_get_contents();
        ob_end_clean();
        return $userHeader;
    }

}