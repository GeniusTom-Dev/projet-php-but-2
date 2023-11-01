<?php
    function checkTab(): void{
        if (!isset($_SESSION['tab'])) {
            $_SESSION['tab'] = 'categories';
        }
        if (isset($_GET['tab'])){
            if ($_GET['tab'] != $_SESSION['tab']){
                $_GET['sort'] = 'ID-asc';
                $_GET['page'] = 1;
                unset($_SESSION['search']);
            }
            $_SESSION['tab'] = $_GET['tab'];
        }
        else
            $_GET['tab'] = $_SESSION['tab'];
    }

    function checkSort(): void{
        if (!isset($_SESSION['sort'])) {
            $_SESSION['sort'] = 'ID-asc';
        }
        if (isset($_GET['sort'])) {
            if ($_GET['sort'] != $_SESSION['sort']) {
                $_GET['page'] = 1;
            }
            $_SESSION['sort'] = $_GET['sort'];
        }
        else
            $_GET['sort'] = $_SESSION['sort'];
    }

    function checkSearch(): void{
        if (isset($_GET['newSearch'])){
            // Go back to first page
            $_GET['page'] = 1;
            // Clear search array in session if exists
            if (isset($_SESSION['search'])){
                unset($_SESSION['search']);
            }
            // Repopulate session array depending on tab
            if ($_GET['tab'] == 'categories') {
                fillSearch('session', SearchParameters::getTopicsSearchParameters());
            }
            else if ($_GET['tab'] == 'utilisateurs') {
                fillSearch('session', SearchParameters::getUsersSearchParameters());
            }
            else if ($_GET['tab'] == 'posts') {
                fillSearch('session', SearchParameters::getPostsSearchParameters());
            }
            else if ($_GET['tab'] == 'commentaires') {
                fillSearch('session', SearchParameters::getCommentsSearchParameters());
            }
        }
        else {
            // Repopulate get array depending on tab
            if ($_GET['tab'] == 'categories') {
                fillSearch('get', SearchParameters::getTopicsSearchParameters());
            }
            else if ($_GET['tab'] == 'utilisateurs') {
                fillSearch('get', SearchParameters::getUsersSearchParameters());
            }
            else if ($_GET['tab'] == 'posts') {
                fillSearch('get', SearchParameters::getPostsSearchParameters());
            }
            else if ($_GET['tab'] == 'commentaires') {
                fillSearch('get', SearchParameters::getCommentsSearchParameters());
            }
        }
    }

    function fillSearch(string $nameArrayToFill, array $params){
        if ($nameArrayToFill == 'get'){
            foreach ($params as $parameter){
                if (isset($_SESSION['search'][$parameter])) {
                    $_GET[$parameter] = $_SESSION['search'][$parameter];
                    //echo $_GET[$parameter], '     ';
                }
            }
        }
        else if ($nameArrayToFill == 'session'){
            foreach ($params as $parameter){
                if (isset($_GET[$parameter])) {
                    $_SESSION['search'][$parameter] = $_GET[$parameter];
                    //echo $_SESSION['search'][$parameter], '     ';
                }
            }
        }
    }

    function checkPage(): void{
        if (!isset($_SESSION['page'])){
            $_SESSION['page'] = 1;
        }
        if (isset($_GET['page'])){
            $_SESSION['page'] = $_GET['page'];
        }
        else {
            $_GET['page'] = $_SESSION['page'];
        }
    }

    function homeReload(): void{
        if ($_GET['tab'] == 'categories') {
            require '../View/admin_views/adminCategories.php';
            //echo '<p>Categorie loadée</p>';
        }
        else if ($_GET['tab'] == 'utilisateurs') {
            require '../View/admin_views/adminUsers.php';
//            echo '<p>', $_GET['utilisateurs'], '</p>';
        }
        else if ($_GET['tab'] == 'posts') {
            require '../View/admin_views/adminPosts.php';
//            echo '<p>', $_GET['posts'], '</p>';
        }
        else if ($_GET['tab'] == 'commentaires') {
            require '../View/admin_views/adminComments.php';
//            echo '<p>', $_GET['commentaires'], '</p>';
        }
        else {
            echo '<p>Rien de selectionné</p>';
        }
    }


?>